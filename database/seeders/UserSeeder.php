<?php
// File: database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản Admin
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@hotel.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Tạo các tài khoản khách hàng
        $customers = [
            ['name' => 'Nguyen Van A', 'email' => 'usera@hotel.com'],
            ['name' => 'Tran Thi B',   'email' => 'userb@hotel.com'],
            ['name' => 'Le Van C',     'email' => 'userc@hotel.com'],
        ];

        foreach ($customers as $customer) {
            User::create([
                'name'     => $customer['name'],
                'email'    => $customer['email'],
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]);
        }
    }
}