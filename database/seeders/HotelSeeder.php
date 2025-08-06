<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Grand Plaza Hotel',
                'description' => 'Luxury 5-star hotel in the heart of downtown with stunning city views and world-class amenities.',
                'location' => 'Downtown',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'USA',
                'address' => '123 Broadway Street',
                'phone' => '+1-555-0123',
                'email' => 'info@grandplaza.com',
                'website' => 'https://grandplaza.com',
                'rating' => 4.8,
                'total_reviews' => 1247,
                'star_rating' => '5',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800'
                ]
            ],
            [
                'name' => 'Oceanview Resort & Spa',
                'description' => 'Beachfront resort offering luxury accommodations with direct access to pristine beaches.',
                'location' => 'Beachfront',
                'city' => 'Miami',
                'state' => 'FL',
                'country' => 'USA',
                'address' => '456 Ocean Drive',
                'phone' => '+1-555-0456',
                'email' => 'reservations@oceanview.com',
                'website' => 'https://oceanview.com',
                'rating' => 4.6,
                'total_reviews' => 892,
                'star_rating' => '4',
                'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800'
                ]
            ],
            [
                'name' => 'Mountain Lodge Retreat',
                'description' => 'Cozy mountain lodge surrounded by nature with hiking trails and scenic views.',
                'location' => 'Mountain',
                'city' => 'Aspen',
                'state' => 'CO',
                'country' => 'USA',
                'address' => '789 Mountain Road',
                'phone' => '+1-555-0789',
                'email' => 'stay@mountainlodge.com',
                'website' => 'https://mountainlodge.com',
                'rating' => 4.4,
                'total_reviews' => 567,
                'star_rating' => '4',
                'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800'
                ]
            ],
            [
                'name' => 'Urban Boutique Hotel',
                'description' => 'Modern boutique hotel in the trendy arts district with contemporary design.',
                'location' => 'Arts District',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'country' => 'USA',
                'address' => '321 Arts Street',
                'phone' => '+1-555-0321',
                'email' => 'hello@urbanboutique.com',
                'website' => 'https://urbanboutique.com',
                'rating' => 4.2,
                'total_reviews' => 445,
                'star_rating' => '3',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800',
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800'
                ]
            ],
            [
                'name' => 'Historic Grand Hotel',
                'description' => 'Century-old hotel with classic architecture and modern luxury amenities.',
                'location' => 'Historic District',
                'city' => 'Boston',
                'state' => 'MA',
                'country' => 'USA',
                'address' => '654 Heritage Lane',
                'phone' => '+1-555-0654',
                'email' => 'reservations@historicgrand.com',
                'website' => 'https://historicgrand.com',
                'rating' => 4.7,
                'total_reviews' => 678,
                'star_rating' => '5',
                'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800',
                    'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800',
                    'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800'
                ]
            ]
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
