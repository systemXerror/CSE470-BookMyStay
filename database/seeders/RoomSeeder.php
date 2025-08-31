<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Amenity;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::all();
        $amenities = Amenity::all();

        foreach ($hotels as $hotel) {
            // Create different room types for each hotel
            $roomTypes = [
                [
                    'room_type' => 'Standard Room',
                    'description' => 'Comfortable room with essential amenities',
                    'price_per_night' => rand(80, 150),
                    'capacity' => 2,
                    'size_sqm' => 25,
                    'count' => 10
                ],
                [
                    'room_type' => 'Deluxe Room',
                    'description' => 'Spacious room with premium amenities and city view',
                    'price_per_night' => rand(150, 250),
                    'capacity' => 3,
                    'size_sqm' => 35,
                    'count' => 8
                ],
                [
                    'room_type' => 'Suite',
                    'description' => 'Luxury suite with separate living area and premium services',
                    'price_per_night' => rand(250, 400),
                    'capacity' => 4,
                    'size_sqm' => 50,
                    'count' => 5
                ],
                [
                    'room_type' => 'Presidential Suite',
                    'description' => 'Ultimate luxury with panoramic views and exclusive services',
                    'price_per_night' => rand(500, 800),
                    'capacity' => 6,
                    'size_sqm' => 80,
                    'count' => 2
                ]
            ];

            foreach ($roomTypes as $roomType) {
                for ($i = 1; $i <= $roomType['count']; $i++) {
                    $room = Room::create([
                        'hotel_id' => $hotel->id,
                        'room_number' => $roomType['room_type'] . ' ' . $i,
                        'room_type' => $roomType['room_type'],
                        'description' => $roomType['description'],
                        'price_per_night' => $roomType['price_per_night'],
                        'capacity' => $roomType['capacity'],
                        'size_sqm' => $roomType['size_sqm'],
                        'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                        'images' => [
                            'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                            'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800',
                            'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800'
                        ]
                    ]);

                    // Attach random amenities to each room
                    $roomAmenities = $amenities->where('type', 'room');
                    if ($roomAmenities->count() > 0) {
                        $selectedAmenities = $roomAmenities->random(rand(3, min(6, $roomAmenities->count())));
                        $room->amenities()->attach($selectedAmenities->pluck('id')->toArray());
                    }
                }
            }
        }
    }
}
