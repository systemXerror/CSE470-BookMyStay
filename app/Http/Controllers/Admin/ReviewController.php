<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews
     */
    public function index()
    {
        $reviews = Review::with(['user', 'reviewable'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Review::count(),
            'approved' => Review::approved()->count(),
            'pending' => Review::pending()->count(),
            'hotel_reviews' => Review::where('reviewable_type', Hotel::class)->count(),
            'room_reviews' => Review::where('reviewable_type', Room::class)->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Show pending reviews
     */
    public function pending()
    {
        $reviews = Review::with(['user', 'reviewable'])
            ->pending()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reviews.pending', compact('reviews'));
    }

    /**
     * Show approved reviews
     */
    public function approved()
    {
        $reviews = Review::with(['user', 'reviewable'])
            ->approved()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reviews.approved', compact('reviews'));
    }

    /**
     * Show the specified review
     */
    public function show($id)
    {
        $review = Review::with(['user', 'reviewable'])->findOrFail($id);
        
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->approve();

        // Update the reviewable's average rating
        if ($review->reviewable_type === Hotel::class) {
            $hotel = Hotel::find($review->reviewable_id);
            $hotel->calculateAverageRating();
        }

        // Create notification for user
        Notification::create([
            'user_id' => $review->user_id,
            'type' => 'review_approved',
            'title' => 'Review Approved',
            'message' => 'Your review has been approved and is now visible.',
            'data' => [
                'review_id' => $review->id,
                'reviewable_type' => $review->reviewable_type,
                'reviewable_id' => $review->reviewable_id
            ]
        ]);

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    /**
     * Reject/Delete a review
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        // Create notification for user
        Notification::create([
            'user_id' => $review->user_id,
            'type' => 'review_rejected',
            'title' => 'Review Rejected',
            'message' => 'Your review has been rejected and removed.',
            'data' => [
                'review_id' => $review->id,
                'reviewable_type' => $review->reviewable_type,
                'reviewable_id' => $review->reviewable_id
            ]
        ]);

        $review->delete();

        // Update the reviewable's average rating if it was approved
        if ($review->is_approved && $review->reviewable_type === Hotel::class) {
            $hotel = Hotel::find($review->reviewable_id);
            $hotel->calculateAverageRating();
        }

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    /**
     * Show hotel reviews
     */
    public function hotelReviews($hotelId)
    {
        $hotel = Hotel::with(['reviews.user'])->findOrFail($hotelId);
        $reviews = $hotel->reviews()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reviews.hotel-reviews', compact('hotel', 'reviews'));
    }

    /**
     * Show room reviews
     */
    public function roomReviews($roomId)
    {
        $room = Room::with(['reviews.user', 'hotel'])->findOrFail($roomId);
        $reviews = $room->reviews()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.reviews.room-reviews', compact('room', 'reviews'));
    }

    /**
     * Bulk approve reviews
     */
    public function bulkApprove(Request $request)
    {
        $reviewIds = $request->input('review_ids', []);
        
        if (empty($reviewIds)) {
            return redirect()->back()->with('error', 'No reviews selected.');
        }

        $reviews = Review::whereIn('id', $reviewIds)->get();
        
        foreach ($reviews as $review) {
            $review->approve();
            
            // Update hotel rating if it's a hotel review
            if ($review->reviewable_type === Hotel::class) {
                $hotel = Hotel::find($review->reviewable_id);
                $hotel->calculateAverageRating();
            }

            // Create notification for user
            Notification::create([
                'user_id' => $review->user_id,
                'type' => 'review_approved',
                'title' => 'Review Approved',
                'message' => 'Your review has been approved and is now visible.',
                'data' => [
                    'review_id' => $review->id,
                    'reviewable_type' => $review->reviewable_type,
                    'reviewable_id' => $review->reviewable_id
                ]
            ]);
        }

        return redirect()->back()->with('success', count($reviews) . ' reviews approved successfully.');
    }

    /**
     * Bulk delete reviews
     */
    public function bulkDelete(Request $request)
    {
        $reviewIds = $request->input('review_ids', []);
        
        if (empty($reviewIds)) {
            return redirect()->back()->with('error', 'No reviews selected.');
        }

        $reviews = Review::whereIn('id', $reviewIds)->get();
        
        foreach ($reviews as $review) {
            // Create notification for user
            Notification::create([
                'user_id' => $review->user_id,
                'type' => 'review_rejected',
                'title' => 'Review Rejected',
                'message' => 'Your review has been rejected and removed.',
                'data' => [
                    'review_id' => $review->id,
                    'reviewable_type' => $review->reviewable_type,
                    'reviewable_id' => $review->reviewable_id
                ]
            ]);

            $review->delete();
        }

        return redirect()->back()->with('success', count($reviews) . ' reviews deleted successfully.');
    }
}
