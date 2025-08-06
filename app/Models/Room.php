<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    protected $fillable = [
        'hotel_id', 'room_number', 'room_type', 'description', 'price_per_night',
        'status', 'capacity', 'size_sqm', 'image', 'images'
    ];

    protected $casts = [
        'images' => 'array',
        'price_per_night' => 'decimal:2',
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities');
    }

    public function bookings(): BelongsToMany
    {
        return $this->hasMany(Booking::class);
    }
}
