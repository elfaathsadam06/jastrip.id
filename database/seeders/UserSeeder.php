<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin Jastrip',
                'email' => 'admin@jastrip.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Owner Jastrip',
                'email' => 'owner@jastrip.id',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ],
            [
                'name' => 'Transkriptor Jastrip',
                'email' => 'transkriptor@jastrip.id',
                'password' => Hash::make('transkriptor123'),
                'role' => 'transkriptor',
            ],
        ]);
    }
}
