<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'room_id', 'check_in_date', 'check_out_date', 
        'guests', 'total_amount', 'status', 'special_requests',
        'extra_services', 'extra_services_amount', 'base_amount',
        'breakfast_included', 'parking_included', 'wifi_included',
        'cancellation_deadline', 'cancellation_fee', 'cancellation_reason',
        'cancelled_at', 'discount_code', 'discount_amount'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
        'extra_services' => 'array',
        'extra_services_amount' => 'decimal:2',
        'base_amount' => 'decimal:2',
        'breakfast_included' => 'boolean',
        'parking_included' => 'boolean',
        'wifi_included' => 'boolean',
        'cancellation_deadline' => 'date',
        'cancellation_fee' => 'decimal:2',
        'cancelled_at' => 'datetime',
        'discount_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'data->booking_id');
    }

    public function specialOffer()
    {
        return $this->belongsTo(SpecialOffer::class, 'discount_code', 'code');
    }

    public function getNightsAttribute()
    {
        return $this->check_in_date->diffInDays($this->check_out_date);
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'confirmed' => 'bg-success',
            'cancelled' => 'bg-danger',
            'completed' => 'bg-info',
            default => 'bg-secondary'
        };
    }

    public function getExtraServicesListAttribute()
    {
        if (!$this->extra_services) {
            return [];
        }

        $services = [];
        if ($this->breakfast_included) $services[] = 'Breakfast';
        if ($this->parking_included) $services[] = 'Parking';
        if ($this->wifi_included) $services[] = 'WiFi';
        
        return array_merge($services, $this->extra_services);
    }

    public function canBeCancelled()
    {
        if ($this->status === 'cancelled' || $this->status === 'completed') {
            return false;
        }

        if ($this->cancellation_deadline) {
            return now()->lt($this->cancellation_deadline);
        }

        // Default: can cancel up to 24 hours before check-in
        return now()->lt($this->check_in_date->subDay());
    }

    public function getCancellationRefundAmount()
    {
        if (!$this->canBeCancelled()) {
            return 0;
        }

        return $this->total_amount - $this->cancellation_fee;
    }

    public function cancel($reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'cancelled_at' => now(),
        ]);

        // Create notification for cancellation
        $this->user->notifications()->create([
            'type' => 'booking_cancelled',
            'title' => 'Booking Cancelled',
            'message' => "Your booking for {$this->room->room_number} has been cancelled.",
            'data' => ['booking_id' => $this->id],
        ]);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('check_in_date', '>', now())
                    ->where('status', '!=', 'cancelled');
    }

    public function scopePast($query)
    {
        return $query->where('check_out_date', '<', now())
                    ->where('status', '!=', 'cancelled');
    }

    public function scopeActive($query)
    {
        return $query->where('check_in_date', '<=', now())
                    ->where('check_out_date', '>=', now())
                    ->where('status', 'confirmed');
    }
}
