<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = [
            // Room Amenities
            ['name' => 'Wi-Fi', 'icon' => 'fas fa-wifi', 'type' => 'room'],
            ['name' => 'Air Conditioning', 'icon' => 'fas fa-snowflake', 'type' => 'room'],
            ['name' => 'TV', 'icon' => 'fas fa-tv', 'type' => 'room'],
            ['name' => 'Mini Bar', 'icon' => 'fas fa-glass-martini', 'type' => 'room'],
            ['name' => 'Room Service', 'icon' => 'fas fa-concierge-bell', 'type' => 'room'],
            ['name' => 'Balcony', 'icon' => 'fas fa-door-open', 'type' => 'room'],
            ['name' => 'Ocean View', 'icon' => 'fas fa-water', 'type' => 'room'],
            ['name' => 'Mountain View', 'icon' => 'fas fa-mountain', 'type' => 'room'],
            ['name' => 'Kitchen', 'icon' => 'fas fa-utensils', 'type' => 'room'],
            ['name' => 'Jacuzzi', 'icon' => 'fas fa-hot-tub', 'type' => 'room'],
            ['name' => 'King Bed', 'icon' => 'fas fa-bed', 'type' => 'room'],
            ['name' => 'Queen Bed', 'icon' => 'fas fa-bed', 'type' => 'room'],
            ['name' => 'Twin Beds', 'icon' => 'fas fa-bed', 'type' => 'room'],
            ['name' => 'Private Bathroom', 'icon' => 'fas fa-bath', 'type' => 'room'],
            ['name' => 'Shower', 'icon' => 'fas fa-shower', 'type' => 'room'],
            ['name' => 'Hair Dryer', 'icon' => 'fas fa-wind', 'type' => 'room'],
            ['name' => 'Safe', 'icon' => 'fas fa-vault', 'type' => 'room'],
            ['name' => 'Work Desk', 'icon' => 'fas fa-desktop', 'type' => 'room'],
            ['name' => 'Coffee Maker', 'icon' => 'fas fa-coffee', 'type' => 'room'],
            ['name' => 'Iron & Board', 'icon' => 'fas fa-iron', 'type' => 'room'],
            
            // Hotel Amenities
            ['name' => 'Swimming Pool', 'icon' => 'fas fa-swimming-pool', 'type' => 'hotel'],
            ['name' => 'Spa', 'icon' => 'fas fa-spa', 'type' => 'hotel'],
            ['name' => 'Gym', 'icon' => 'fas fa-dumbbell', 'type' => 'hotel'],
            ['name' => 'Restaurant', 'icon' => 'fas fa-utensils', 'type' => 'hotel'],
            ['name' => 'Bar', 'icon' => 'fas fa-glass-martini-alt', 'type' => 'hotel'],
            ['name' => 'Conference Room', 'icon' => 'fas fa-users', 'type' => 'hotel'],
            ['name' => 'Business Center', 'icon' => 'fas fa-briefcase', 'type' => 'hotel'],
            ['name' => 'Free Parking', 'icon' => 'fas fa-parking', 'type' => 'hotel'],
            ['name' => 'Airport Shuttle', 'icon' => 'fas fa-shuttle-van', 'type' => 'hotel'],
            ['name' => 'Laundry Service', 'icon' => 'fas fa-tshirt', 'type' => 'hotel'],
            ['name' => '24/7 Front Desk', 'icon' => 'fas fa-clock', 'type' => 'hotel'],
            ['name' => 'Luggage Storage', 'icon' => 'fas fa-suitcase', 'type' => 'hotel'],
            ['name' => 'Tour Desk', 'icon' => 'fas fa-map-marked-alt', 'type' => 'hotel'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}
