<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SpecialOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'discount_value',
        'minimum_amount',
        'max_uses',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'applicable_hotels',
        'applicable_room_types',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'applicable_hotels' => 'array',
        'applicable_room_types' => 'array',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function scopeValid($query)
    {
        return $query->active()
                    ->where(function ($q) {
                        $q->whereNull('max_uses')
                          ->orWhereRaw('used_count < max_uses');
                    });
    }

    // Methods
    public function isValid()
    {
        return $this->is_active &&
               $this->start_date <= now() &&
               $this->end_date >= now() &&
               ($this->max_uses === null || $this->used_count < $this->max_uses);
    }

    public function canBeApplied($amount, $hotelId = null, $roomType = null)
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($amount < $this->minimum_amount) {
            return false;
        }

        // Check if hotel is applicable
        if ($this->applicable_hotels) {
            $applicableHotels = is_string($this->applicable_hotels) ? json_decode($this->applicable_hotels, true) : $this->applicable_hotels;
            if ($applicableHotels && !in_array((int)$hotelId, array_map('intval', $applicableHotels))) {
                return false;
            }
        }

        // Check if room type is applicable
        if ($this->applicable_room_types) {
            $applicableRoomTypes = is_string($this->applicable_room_types) ? json_decode($this->applicable_room_types, true) : $this->applicable_room_types;
            if ($applicableRoomTypes && !in_array($roomType, $applicableRoomTypes)) {
                return false;
            }
        }

        return true;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            return ($amount * $this->discount_value) / 100;
        }

        return min($this->discount_value, $amount);
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    public function getRemainingUsesAttribute()
    {
        if ($this->max_uses === null) {
            return null;
        }

        return max(0, $this->max_uses - $this->used_count);
    }

    public function getDaysRemainingAttribute()
    {
        return max(0, now()->diffInDays($this->end_date, false));
    }

    public function getUsagePercentageAttribute()
    {
        if ($this->max_uses === null) {
            return 0;
        }

        return ($this->used_count / $this->max_uses) * 100;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'discount_code', 'code');
    }

    public static function getActiveOffers()
    {
        return self::active()->get();
    }
}
