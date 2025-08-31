<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show the review form for a hotel
     */
    public function createHotelReview($hotelId)
    {
        $hotel = Hotel::findOrFail($hotelId);
        
        // Check if user has already reviewed this hotel
        if (!Review::canUserReview(Auth::id(), Hotel::class, $hotelId)) {
            return redirect()->back()->with('error', 'You have already reviewed this hotel.');
        }

        return view('user.reviews.create-hotel', compact('hotel'));
    }

    /**
     * Show the review form for a room
     */
    public function createRoomReview($roomId)
    {
        $room = Room::with('hotel')->findOrFail($roomId);
        
        // Check if user has already reviewed this room
        if (!Review::canUserReview(Auth::id(), Room::class, $roomId)) {
            return redirect()->back()->with('error', 'You have already reviewed this room.');
        }

        return view('user.reviews.create-room', compact('room'));
    }

    /**
     * Store a hotel review
     */
    public function storeHotelReview(Request $request, $hotelId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $hotel = Hotel::findOrFail($hotelId);
        
        // Check if user has already reviewed this hotel
        if (!Review::canUserReview(Auth::id(), Hotel::class, $hotelId)) {
            return redirect()->back()->with('error', 'You have already reviewed this hotel.');
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'reviewable_type' => Hotel::class,
            'reviewable_id' => $hotelId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false
        ]);

        // Create notification for admin
        Notification::create([
            'user_id' => 1, // Admin user
            'type' => 'new_review',
            'title' => 'New Hotel Review',
            'message' => 'A new review has been submitted for ' . $hotel->name,
            'data' => [
                'review_id' => $review->id,
                'hotel_id' => $hotelId,
                'reviewer_name' => Auth::user()->name
            ]
        ]);

        return redirect()->route('hotels.show', $hotelId)
            ->with('success', 'Your review has been submitted and is pending approval.');
    }

    /**
     * Store a room review
     */
    public function storeRoomReview(Request $request, $roomId)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $room = Room::findOrFail($roomId);
        
        // Check if user has already reviewed this room
        if (!Review::canUserReview(Auth::id(), Room::class, $roomId)) {
            return redirect()->back()->with('error', 'You have already reviewed this room.');
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'reviewable_type' => Room::class,
            'reviewable_id' => $roomId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false
        ]);

        // Create notification for admin
        Notification::create([
            'user_id' => 1, // Admin user
            'type' => 'new_review',
            'title' => 'New Room Review',
            'message' => 'A new review has been submitted for Room ' . $room->room_number . ' at ' . $room->hotel->name,
            'data' => [
                'review_id' => $review->id,
                'room_id' => $roomId,
                'hotel_id' => $room->hotel_id,
                'reviewer_name' => Auth::user()->name
            ]
        ]);

        return redirect()->route('rooms.show', $roomId)
            ->with('success', 'Your review has been submitted and is pending approval.');
    }

    /**
     * Show user's reviews
     */
    public function myReviews()
    {
        $reviews = Auth::user()->reviews()
            ->with(['reviewable' => function($query) {
                $query->with('hotel');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Auth::user()->reviews()->count(),
            'approved' => Auth::user()->reviews()->approved()->count(),
            'pending' => Auth::user()->reviews()->pending()->count(),
            'hotel_reviews' => Auth::user()->reviews()->where('reviewable_type', Hotel::class)->count(),
            'room_reviews' => Auth::user()->reviews()->where('reviewable_type', Room::class)->count(),
        ];

        return view('user.reviews.my-reviews', compact('reviews', 'stats'));
    }

    /**
     * Show reviews for a hotel
     */
    public function hotelReviews($hotelId)
    {
        $hotel = Hotel::with(['approvedReviews.user'])->findOrFail($hotelId);
        $reviews = $hotel->approvedReviews()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.reviews.hotel-reviews', compact('hotel', 'reviews'));
    }

    /**
     * Show reviews for a room
     */
    public function roomReviews($roomId)
    {
        $room = Room::with(['approvedReviews.user', 'hotel'])->findOrFail($roomId);
        $reviews = $room->approvedReviews()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.reviews.room-reviews', compact('room', 'reviews'));
    }
}
