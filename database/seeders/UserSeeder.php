<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Direktur
        User::create([
            'username' => 'direktur',
            'password' => Hash::make('marketing123'),
            'role' => 'direktur',
        ]);

        // 2. Akun Marketing
        User::create([
            'username' => 'marketing',
            'password' => Hash::make('marketing123'),
            'role' => 'marketing',
        ]);

        // 3. Akun Engineering
        User::create([
            'username' => 'engineering',
            'password' => Hash::make('marketing123'),
            'role' => 'engineering',
        ]);

        // 4. Akun Purchasing
        User::create([
            'username' => 'purchasing',
            'password' => Hash::make('marketing123'),
            'role' => 'purchasing',
        ]);
    }
}