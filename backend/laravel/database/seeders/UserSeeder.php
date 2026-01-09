<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['email' => 'yawwwmusik@gmail.com'],
            [
                'name' => 'Admin Yawww',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // USER BIASA
        User::updateOrCreate(
            ['email' => 'rawr@gmail.com'],
            [
                'name' => 'rawr',
                'password' => Hash::make('rawr123'),
                'role' => 'user',
            ]
        );
    }
}
