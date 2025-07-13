<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Mentor One',
    'email' => 'mentor@example.com',
    'password' => Hash::make('password'),
    'role' => 'mentor',
]);

User::create([
    'name' => 'Pelari One',
    'email' => 'pelari@example.com',
    'password' => Hash::make('password'),
    'role' => 'pelari',
]);