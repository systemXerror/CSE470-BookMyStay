<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes instead
    }

    public function dashboard()
    {
        // Get basic statistics
        $totalHotels = Hotel::count();
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $totalUsers = User::where('is_admin', false)->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_amount');
        
        // Enhanced booking statistics
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();
        $completedBookings = Booking::where('status', 'completed')->count();
        
        // Revenue statistics
        $monthlyRevenue = Booking::where('status', 'confirmed')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('strftime("%m", created_at) as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->get();
        
        $extraServicesRevenue = Booking::sum('extra_services_amount');
        $cancellationFees = Booking::where('status', 'cancelled')->sum('cancellation_fee');
        
        // Recent activities
        $recentBookings = Booking::with(['user', 'room.hotel'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        $recentUsers = User::where('is_admin', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Popular services
        $popularServices = DB::table('bookings')
            ->selectRaw('extra_services, COUNT(*) as count')
            ->whereNotNull('extra_services')
            ->where('extra_services', '!=', '[]')
            ->groupBy('extra_services')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();
        
        // Upcoming check-ins
        $upcomingCheckIns = Booking::with(['user', 'room.hotel'])
            ->where('check_in_date', '>=', now())
            ->where('check_in_date', '<=', now()->addDays(7))
            ->where('status', 'confirmed')
            ->orderBy('check_in_date')
            ->take(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalHotels', 
            'totalRooms', 
            'totalBookings', 
            'totalUsers', 
            'totalRevenue',
            'confirmedBookings',
            'pendingBookings',
            'cancelledBookings',
            'completedBookings',
            'monthlyRevenue',
            'extraServicesRevenue',
            'cancellationFees',
            'recentBookings',
            'recentUsers',
            'popularServices',
            'upcomingCheckIns'
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
        
        // Booking statistics for the page
        $bookingStats = [
            'total' => Booking::count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];
        
        return view('admin.bookings.index', compact('bookings', 'bookingStats'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::with('user')->findOrFail($id);
        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        // Create notification for status change
        if ($oldStatus !== $request->status) {
            $booking->user->notifications()->create([
                'type' => 'booking_status_changed',
                'title' => 'Booking Status Updated',
                'message' => "Your booking for {$booking->room->room_number} has been updated to {$request->status}.",
                'data' => ['booking_id' => $booking->id],
            ]);
        }

        return redirect()->route('admin.bookings')->with('success', 'Booking status updated successfully!');
    }

    public function users()
    {
        $users = User::where('is_admin', false)
            ->withCount(['bookings', 'notifications'])
            ->paginate(15);
        
        // User activity statistics
        $userStats = [
            'total' => User::where('is_admin', false)->count(),
            'active' => User::where('is_admin', false)->whereHas('bookings')->count(),
            'new_this_month' => User::where('is_admin', false)
                ->whereMonth('created_at', now()->month)
                ->count(),
        ];
        
        return view('admin.users.index', compact('users', 'userStats'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);

        return redirect()->route('admin.users')->with('success', 'User status updated successfully!');
    }

    public function userActivity($userId)
    {
        $user = User::with(['bookings.room.hotel', 'notifications'])->findOrFail($userId);
        
        $recentBookings = $user->bookings()->orderBy('created_at', 'desc')->take(10)->get();
        $recentNotifications = $user->notifications()->orderBy('created_at', 'desc')->take(10)->get();
        
        return view('admin.users.activity', compact('user', 'recentBookings', 'recentNotifications'));
    }

    public function bookingStatistics()
    {
        // Monthly booking trends
        $monthlyBookings = Booking::whereYear('created_at', date('Y'))
            ->selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();
        
        // Revenue by hotel
        $revenueByHotel = Booking::with('room.hotel')
            ->where('bookings.status', 'confirmed')
            ->selectRaw('hotels.name, SUM(bookings.total_amount) as revenue')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->groupBy('hotels.id', 'hotels.name')
            ->orderBy('revenue', 'desc')
            ->get();
        
        // Popular room types
        $popularRoomTypes = Booking::with('room')
            ->selectRaw('rooms.room_type, COUNT(*) as count')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->groupBy('rooms.room_type')
            ->orderBy('count', 'desc')
            ->get();
        
        // Extra services usage
        $extraServicesUsage = DB::table('bookings')
            ->selectRaw('extra_services, COUNT(*) as count')
            ->whereNotNull('extra_services')
            ->where('extra_services', '!=', '[]')
            ->groupBy('extra_services')
            ->orderBy('count', 'desc')
            ->get();
        
        return view('admin.statistics', compact(
            'monthlyBookings',
            'revenueByHotel',
            'popularRoomTypes',
            'extraServicesUsage'
        ));
    }

    public function notifications()
    {
        $notifications = Notification::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $notificationStats = [
            'total' => Notification::count(),
            'unread' => Notification::where('read', false)->count(),
            'read' => Notification::where('read', true)->count(),
        ];
        
        return view('admin.notifications.index', compact('notifications', 'notificationStats'));
    }
}
