<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SpecialOffer;

class SpecialOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some test special offers
        SpecialOffer::create([
            'name' => 'Welcome Discount',
            'code' => 'WELCOME10',
            'description' => 'Get 10% off your first booking',
            'type' => 'percentage',
            'discount_value' => 10,
            'minimum_amount' => 100,
            'max_uses' => 100,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'is_active' => true,
            'applicable_hotels' => null, // All hotels
            'applicable_room_types' => null, // All room types
        ]);

        SpecialOffer::create([
            'name' => 'Summer Savings',
            'code' => 'SUMMER50',
            'description' => 'Get $50 off bookings over $200',
            'type' => 'fixed_amount',
            'discount_value' => 50,
            'minimum_amount' => 200,
            'max_uses' => 50,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
            'applicable_hotels' => null, // All hotels
            'applicable_room_types' => null, // All room types
        ]);

        SpecialOffer::create([
            'name' => 'Luxury Suite Discount',
            'code' => 'LUXURY20',
            'description' => 'Get 20% off luxury suites',
            'type' => 'percentage',
            'discount_value' => 20,
            'minimum_amount' => 300,
            'max_uses' => 25,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addMonths(4),
            'is_active' => true,
            'applicable_hotels' => null, // All hotels
            'applicable_room_types' => ['Suite', 'Executive', 'Presidential'], // Only luxury room types
        ]);

        SpecialOffer::create([
            'name' => 'Weekend Special',
            'code' => 'WEEKEND25',
            'description' => 'Get 25% off weekend bookings',
            'type' => 'percentage',
            'discount_value' => 25,
            'minimum_amount' => 150,
            'max_uses' => 75,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addMonths(2),
            'is_active' => true,
            'applicable_hotels' => null, // All hotels
            'applicable_room_types' => null, // All room types
        ]);
    }
}
