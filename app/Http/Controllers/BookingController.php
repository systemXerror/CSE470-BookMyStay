<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Notification;
use App\Models\SpecialOffer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

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
                ->where('status', '!=', 'cancelled')
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

        $activeOffers = SpecialOffer::getActiveOffers();
        return view('user.booking-form', compact('room', 'checkIn', 'checkOut', 'guests', 'totalPrice', 'nights', 'isAvailable', 'activeOffers'));
    }

    public function store(Request $request, $hotelId, $roomId)
    {
        $request->validate([
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:500',
            'breakfast_included' => 'boolean',
            'parking_included' => 'boolean',
            'wifi_included' => 'boolean',
            'extra_services' => 'nullable|array',
            'discount_code' => 'nullable|string|max:50',
        ]);

        $room = Room::findOrFail($roomId);
        
        // Check if room belongs to the specified hotel
        if ($room->hotel_id != $hotelId) {
            abort(404);
        }

        // Check availability again
        $conflictingBookings = Booking::where('room_id', $roomId)
            ->where('status', '!=', 'cancelled')
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

        // Calculate base amount
        $checkInDate = new \DateTime($request->check_in_date);
        $checkOutDate = new \DateTime($request->check_out_date);
        $nights = $checkInDate->diff($checkOutDate)->days;
        $baseAmount = $nights * $room->price_per_night;

        // Calculate extra services amount
        $extraServicesAmount = 0;
        $extraServices = [];

        if ($request->breakfast_included) {
            $extraServicesAmount += 15 * $nights; // $15 per night for breakfast
            $extraServices[] = 'Breakfast';
        }

        if ($request->parking_included) {
            $extraServicesAmount += 10 * $nights; // $10 per night for parking
            $extraServices[] = 'Parking';
        }

        if ($request->wifi_included) {
            $extraServicesAmount += 5 * $nights; // $5 per night for WiFi
            $extraServices[] = 'WiFi';
        }

        if ($request->extra_services) {
            foreach ($request->extra_services as $service) {
                $extraServices[] = $service;
                // Add custom pricing for extra services
                switch ($service) {
                    case 'Room Service':
                        $extraServicesAmount += 20 * $nights;
                        break;
                    case 'Spa Access':
                        $extraServicesAmount += 50 * $nights;
                        break;
                    case 'Gym Access':
                        $extraServicesAmount += 10 * $nights;
                        break;
                    default:
                        $extraServicesAmount += 15 * $nights;
                }
            }
        }

        $totalAmount = $baseAmount + $extraServicesAmount;

        // Apply discount code if provided
        $discountAmount = 0;
        $discountCode = null;
        
        if ($request->discount_code) {
            $specialOffer = SpecialOffer::where('code', $request->discount_code)->first();
            
            if ($specialOffer && $specialOffer->canBeApplied($totalAmount, $room->hotel_id, $room->room_type)) {
                $discountAmount = $specialOffer->calculateDiscount($totalAmount);
                $totalAmount -= $discountAmount;
                $discountCode = $specialOffer->code;
                
                // Increment usage count
                $specialOffer->incrementUsage();
            }
        }

        // Set cancellation deadline (24 hours before check-in)
        $cancellationDeadline = Carbon::parse($request->check_in_date)->subDay();

        // Create booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $roomId,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'guests' => $request->guests,
            'base_amount' => $baseAmount,
            'extra_services_amount' => $extraServicesAmount,
            'total_amount' => $totalAmount,
            'special_requests' => $request->special_requests,
            'breakfast_included' => $request->breakfast_included ?? false,
            'parking_included' => $request->parking_included ?? false,
            'wifi_included' => $request->wifi_included ?? false,
            'extra_services' => $extraServices,
            'cancellation_deadline' => $cancellationDeadline,
            'cancellation_fee' => $baseAmount * 0.1, // 10% cancellation fee
            'discount_code' => $discountCode,
            'discount_amount' => $discountAmount,
            'status' => 'confirmed',
        ]);

        // Create booking confirmation notification
        Auth::user()->notifications()->create([
            'type' => 'booking_confirmation',
            'title' => 'Booking Confirmed',
            'message' => "Your booking for {$room->room_number} at {$room->hotel->name} has been confirmed. Check-in: {$request->check_in_date}",
            'data' => ['booking_id' => $booking->id],
        ]);

        // Store booking ID in session for confirmation page
        Session::flash('booking_id', $booking->id);

        return redirect()->route('user.booking.confirmation', $booking->id);
    }

    public function validateDiscountCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
            'amount' => 'required|numeric|min:0',
            'hotel_id' => 'required|exists:hotels,id',
            'room_type' => 'required|string',
        ]);

        $specialOffer = SpecialOffer::where('code', $request->code)->first();
        
        if (!$specialOffer) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid discount code.'
            ]);
        }

        // Debug information
        $debug = [
            'offer_id' => $specialOffer->id,
            'offer_name' => $specialOffer->name,
            'is_active' => $specialOffer->is_active,
            'start_date' => $specialOffer->start_date->format('Y-m-d'),
            'end_date' => $specialOffer->end_date->format('Y-m-d'),
            'minimum_amount' => $specialOffer->minimum_amount,
            'amount_provided' => $request->amount,
            'hotel_id_provided' => $request->hotel_id,
            'room_type_provided' => $request->room_type,
            'applicable_hotels' => $specialOffer->applicable_hotels,
            'applicable_room_types' => $specialOffer->applicable_room_types,
        ];

        if (!$specialOffer->canBeApplied($request->amount, $request->hotel_id, $request->room_type)) {
            return response()->json([
                'valid' => false,
                'message' => 'This discount code cannot be applied to your booking.',
                'debug' => $debug
            ]);
        }

        $discountAmount = $specialOffer->calculateDiscount($request->amount);

        return response()->json([
            'valid' => true,
            'message' => 'Discount code applied successfully!',
            'discount_amount' => $discountAmount,
            'discount_type' => $specialOffer->type,
            'discount_value' => $specialOffer->discount_value,
            'code' => $specialOffer->code,
            'debug' => $debug
        ]);
    }

    public function testDiscountCode($code)
    {
        $specialOffer = SpecialOffer::where('code', $code)->first();
        
        if (!$specialOffer) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid discount code.'
            ]);
        }

        // Test with default values
        $amount = 150;
        $hotelId = 1;
        $roomType = 'Standard';

        $debug = [
            'offer_id' => $specialOffer->id,
            'offer_name' => $specialOffer->name,
            'is_active' => $specialOffer->is_active,
            'start_date' => $specialOffer->start_date->format('Y-m-d'),
            'end_date' => $specialOffer->end_date->format('Y-m-d'),
            'minimum_amount' => $specialOffer->minimum_amount,
            'amount_provided' => $amount,
            'hotel_id_provided' => $hotelId,
            'room_type_provided' => $roomType,
            'applicable_hotels' => $specialOffer->applicable_hotels,
            'applicable_room_types' => $specialOffer->applicable_room_types,
        ];

        $isValid = $specialOffer->isValid();
        $canBeApplied = $specialOffer->canBeApplied($amount, $hotelId, $roomType);
        $discountAmount = $specialOffer->calculateDiscount($amount);

        return response()->json([
            'valid' => $isValid && $canBeApplied,
            'message' => $isValid && $canBeApplied ? 'Discount code is valid!' : 'Discount code cannot be applied.',
            'discount_amount' => $discountAmount,
            'discount_type' => $specialOffer->type,
            'discount_value' => $specialOffer->discount_value,
            'code' => $specialOffer->code,
            'debug' => $debug,
            'is_valid' => $isValid,
            'can_be_applied' => $canBeApplied
        ]);
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
        $upcomingBookings = Auth::user()->upcomingBookings()->paginate(5);
        $pastBookings = Auth::user()->pastBookings()->paginate(5);
        $activeBookings = Auth::user()->activeBookings()->get();

        return view('user.my-bookings', compact('upcomingBookings', 'pastBookings', 'activeBookings'));
    }

    public function cancelBooking(Request $request, $bookingId)
    {
        $booking = Booking::with('room.hotel')->findOrFail($bookingId);
        
        // Ensure user can only cancel their own bookings
        if ($booking->user_id != Auth::id()) {
            abort(403);
        }

        if (!$booking->canBeCancelled()) {
            return back()->withErrors(['cancellation' => 'This booking cannot be cancelled.']);
        }

        $reason = $request->input('cancellation_reason');
        $booking->cancel($reason);

        return back()->with('success', 'Booking cancelled successfully. Refund amount: $' . number_format($booking->getCancellationRefundAmount(), 2));
    }

    public function notifications()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.notifications', compact('notifications'));
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = Notification::findOrFail($notificationId);
        
        if ($notification->user_id != Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read.');
    }

    public function markAllNotificationsAsRead()
    {
        Auth::user()->notifications()->unread()->update([
            'read' => true,
            'read_at' => now(),
        ]);

        return back()->with('success', 'All notifications marked as read.');
    }
}
