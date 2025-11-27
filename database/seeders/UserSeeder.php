<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin KdTech',
            'email' => 'admin@kdtech.tg',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+228 90 12 34 56',
            'address' => 'Lomé, Togo'
        ]);

        // Manager user
        User::create([
            'name' => 'Manager KdTech',
            'email' => 'manager@kdtech.tg',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '+228 91 23 45 67',
            'address' => 'Lomé, Togo'
        ]);

        // Customer user
        User::create([
            'name' => 'Client Test',
            'email' => 'client@kdtech.tg',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '+228 92 34 56 78',
            'address' => 'Lomé, Togo'
        ]);
    }
}
