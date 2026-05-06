<?php
// File: database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Thứ tự phải đúng theo dependency
        $this->call([
            AmenitySeeder::class,  // Tiện nghi (không phụ thuộc)
            UserSeeder::class,     // Users (không phụ thuộc)
            HotelSeeder::class,    // Hotels (phụ thuộc Users + Amenities)
            RoomSeeder::class,     // Rooms (phụ thuộc Hotels)
            BookingSeeder::class,  // Bookings (phụ thuộc Users + Hotels + Rooms)
        ]);
    }
}