<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}";
    }
}
