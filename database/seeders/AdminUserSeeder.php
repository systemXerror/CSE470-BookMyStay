<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bookmystay.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Create a regular user for testing
        User::create([
            'name' => 'Test User',
            'email' => 'user@bookmystay.com',
            'password' => Hash::make('user123'),
            'is_admin' => false,
        ]);
    }
}
