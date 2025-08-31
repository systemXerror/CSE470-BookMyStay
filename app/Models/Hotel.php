<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hotel extends Model
{
    protected $fillable = [
        'name', 'description', 'location', 'city', 'state', 'country', 'address',
        'phone', 'email', 'website', 'rating', 'total_reviews', 'image', 'images',
        'star_rating', 'is_active'
    ];

    protected $casts = [
        'images' => 'array',
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get all reviews for this hotel
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get approved reviews for this hotel
     */
    public function approvedReviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable')->approved();
    }

    /**
     * Calculate average rating
     */
    public function calculateAverageRating()
    {
        $avgRating = $this->approvedReviews()->avg('rating');
        $totalReviews = $this->approvedReviews()->count();
        
        $this->update([
            'rating' => $avgRating ?: 0,
            'total_reviews' => $totalReviews
        ]);
    }

    /**
     * Get star rating display
     */
    public function getStarRatingDisplayAttribute()
    {
        $stars = '';
        $rating = round($this->rating);
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star text-warning"></i>';
            } else {
                $stars .= '<i class="far fa-star text-warning"></i>';
            }
        }
        return $stars;
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}";
    }
}
