<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::with(['rooms' => function($q) {
            $q->where('status', 'available');
        }]);

        // Filter by location
        if ($request->filled('location')) {
            $query->where('city', 'like', '%' . $request->location . '%')
                  ->orWhere('state', 'like', '%' . $request->location . '%')
                  ->orWhere('country', 'like', '%' . $request->location . '%');
        }

        // Filter by price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $query->whereHas('rooms', function($q) use ($request) {
                if ($request->filled('min_price')) {
                    $q->where('price_per_night', '>=', $request->min_price);
                }
                if ($request->filled('max_price')) {
                    $q->where('price_per_night', '<=', $request->max_price);
                }
            });
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Filter by star rating
        if ($request->filled('star_rating')) {
            $query->where('star_rating', $request->star_rating);
        }

        $hotels = $query->where('is_active', true)->paginate(12);

        return view('user.hotels', compact('hotels'));
    }

    public function showHotel($id)
    {
        $hotel = Hotel::with(['rooms' => function($q) {
            $q->with('amenities');
        }])->findOrFail($id);

        return view('user.hotel-detail', compact('hotel'));
    }

    public function showRoom($hotelId, $roomId)
    {
        $room = Room::with(['hotel', 'amenities'])->findOrFail($roomId);
        
        // Check availability for selected dates
        $checkIn = request('check_in');
        $checkOut = request('check_out');
        
        $isAvailable = true;
        if ($checkIn && $checkOut) {
            $conflictingBookings = Booking::where('room_id', $roomId)
                ->where(function($q) use ($checkIn, $checkOut) {
                    $q->whereBetween('check_in_date', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                      ->orWhere(function($q) use ($checkIn, $checkOut) {
                          $q->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                      });
                })->exists();
            
            $isAvailable = !$conflictingBookings;
        }

        return view('user.room-detail', compact('room', 'isAvailable'));
    }

    public function search(Request $request)
    {
        $query = Hotel::with(['rooms' => function($q) {
            $q->where('status', 'available');
        }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('city', 'like', '%' . $search . '%')
                  ->orWhere('state', 'like', '%' . $search . '%');
            });
        }

        $hotels = $query->where('is_active', true)->get();

        return response()->json($hotels);
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get user's booking statistics
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->count();
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $totalSpent = Booking::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->sum('total_amount');
        
        // Get recent bookings
        $recentBookings = Booking::with(['room.hotel'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Get upcoming bookings
        $upcomingBookings = Booking::with(['room.hotel'])
            ->where('user_id', $user->id)
            ->where('check_in_date', '>=', now())
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('check_in_date', 'asc')
            ->take(3)
            ->get();
        
        // Get favorite hotels (hotels with most bookings)
        $favoriteHotels = Hotel::join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
            ->join('bookings', 'rooms.id', '=', 'bookings.room_id')
            ->where('bookings.user_id', $user->id)
            ->select(
                'hotels.id',
                'hotels.name',
                'hotels.city',
                'hotels.state',
                'hotels.image',
                'hotels.rating',
                'hotels.star_rating',
                DB::raw('COUNT(bookings.id) as booking_count')
            )
            ->groupBy('hotels.id', 'hotels.name', 'hotels.city', 'hotels.state', 'hotels.image', 'hotels.rating', 'hotels.star_rating')
            ->orderBy('booking_count', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'totalBookings',
            'activeBookings', 
            'completedBookings',
            'totalSpent',
            'recentBookings',
            'upcomingBookings',
            'favoriteHotels'
        ));
    }
}
