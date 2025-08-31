<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Room extends Model
{
    protected $fillable = [
        'hotel_id', 'room_number', 'room_type', 'description', 'price_per_night',
        'status', 'capacity', 'size', 'floor', 'is_available', 'image', 'images'
    ];

    protected $casts = [
        'images' => 'array',
        'price_per_night' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all reviews for this room
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get approved reviews for this room
     */
    public function approvedReviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable')->approved();
    }

    /**
     * Get star rating display
     */
    public function getStarRatingDisplayAttribute()
    {
        $avgRating = $this->approvedReviews()->avg('rating');
        if (!$avgRating) {
            return '<span class="text-muted">No reviews yet</span>';
        }

        $stars = '';
        $rating = round($avgRating);
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-warning"></i>';
            }
        }
        return $stars . ' <small class="text-muted">(' . number_format($avgRating, 1) . ')</small>';
    }
}
