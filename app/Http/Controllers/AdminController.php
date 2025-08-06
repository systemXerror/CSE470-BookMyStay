<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes instead
    }

    public function dashboard()
    {
        // Get statistics
        $totalHotels = Hotel::count();
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_amount');
        
        // Recent bookings
        $recentBookings = Booking::with(['user', 'room.hotel'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Monthly revenue data
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalHotels', 
            'totalRooms', 
            'totalBookings', 
            'totalUsers', 
            'totalRevenue',
            'recentBookings',
            'monthlyRevenue'
        ));
    }

    public function hotels()
    {
        $hotels = Hotel::withCount('rooms')->paginate(10);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function createHotel()
    {
        return view('admin.hotels.create');
    }

    public function storeHotel(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'rating' => 'required|numeric|min:0|max:5',
            'total_reviews' => 'required|integer|min:0',
            'star_rating' => 'required|integer|min:1|max:5',
            'image' => 'required|url',
        ]);

        Hotel::create($request->all());

        return redirect()->route('admin.hotels')->with('success', 'Hotel created successfully!');
    }

    public function editHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function updateHotel(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|url',
            'rating' => 'required|numeric|min:0|max:5',
            'total_reviews' => 'required|integer|min:0',
            'star_rating' => 'required|integer|min:1|max:5',
            'image' => 'required|url',
        ]);

        $hotel->update($request->all());

        return redirect()->route('admin.hotels')->with('success', 'Hotel updated successfully!');
    }

    public function deleteHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('admin.hotels')->with('success', 'Hotel deleted successfully!');
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'room.hotel'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return redirect()->route('admin.bookings')->with('success', 'Booking status updated successfully!');
    }

    public function users()
    {
        $users = User::where('is_admin', false)->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        return redirect()->route('admin.users')->with('success', 'User status updated successfully!');
    }
}
