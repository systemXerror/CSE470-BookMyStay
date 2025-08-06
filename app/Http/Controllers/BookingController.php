<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes instead
    }

    public function showBookingForm($hotelId, $roomId)
    {
        $room = Room::with(['hotel', 'amenities'])->findOrFail($roomId);
        
        // Check if room belongs to the specified hotel
        if ($room->hotel_id != $hotelId) {
            abort(404);
        }

        $checkIn = request('check_in');
        $checkOut = request('check_out');
        $guests = request('guests', 1);

        // Calculate total price
        $totalPrice = 0;
        $nights = 0;
        if ($checkIn && $checkOut) {
            $checkInDate = new \DateTime($checkIn);
            $checkOutDate = new \DateTime($checkOut);
            $nights = $checkInDate->diff($checkOutDate)->days;
            $totalPrice = $nights * $room->price_per_night;
        }

        // Check availability
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

        return view('user.booking-form', compact('room', 'checkIn', 'checkOut', 'guests', 'totalPrice', 'nights', 'isAvailable'));
    }

    public function store(Request $request, $hotelId, $roomId)
    {
        $request->validate([
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $room = Room::findOrFail($roomId);
        
        // Check if room belongs to the specified hotel
        if ($room->hotel_id != $hotelId) {
            abort(404);
        }

        // Check availability again
        $conflictingBookings = Booking::where('room_id', $roomId)
            ->where(function($q) use ($request) {
                $q->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                  ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                  ->orWhere(function($q) use ($request) {
                      $q->where('check_in_date', '<=', $request->check_in_date)
                        ->where('check_out_date', '>=', $request->check_out_date);
                  });
            })->exists();

        if ($conflictingBookings) {
            return back()->withErrors(['dates' => 'The selected dates are not available for this room.']);
        }

        // Calculate total amount
        $checkInDate = new \DateTime($request->check_in_date);
        $checkOutDate = new \DateTime($request->check_out_date);
        $nights = $checkInDate->diff($checkOutDate)->days;
        $totalAmount = $nights * $room->price_per_night;

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $roomId,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'guests' => $request->guests,
            'total_amount' => $totalAmount,
            'special_requests' => $request->special_requests,
            'status' => 'confirmed',
        ]);

        // Store booking ID in session for confirmation page
        Session::flash('booking_id', $booking->id);

        return redirect()->route('user.booking.confirmation', $booking->id);
    }

    public function confirmation($bookingId)
    {
        $booking = Booking::with(['user', 'room.hotel'])->findOrFail($bookingId);
        
        // Ensure user can only view their own bookings
        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        return view('user.booking-confirmation', compact('booking'));
    }

    public function myBookings()
    {
        $bookings = Booking::with(['room.hotel'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.my-bookings', compact('bookings'));
    }

    public function cancelBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // Ensure user can only cancel their own bookings
        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        // Only allow cancellation if check-in is more than 24 hours away
        $checkInDate = new \DateTime($booking->check_in_date);
        $now = new \DateTime();
        $hoursUntilCheckIn = $now->diff($checkInDate)->h + ($now->diff($checkInDate)->days * 24);

        if ($hoursUntilCheckIn < 24) {
            return back()->withErrors(['cancellation' => 'Bookings can only be cancelled at least 24 hours before check-in.']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
