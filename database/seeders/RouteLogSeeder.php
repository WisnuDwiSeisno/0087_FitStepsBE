<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RouteLog;

RouteLog::create([
    'user_id' => 2,
    'challenge_id' => 1,
    'date' => now()->toDateString(),
    'path' => json_encode([
        ['lat' => -6.97, 'lng' => 107.63],
        ['lat' => -6.96, 'lng' => 107.64],
    ]),
    'distance_km' => 1.2,
    'duration_min' => 15,
    'avg_speed_kmh' => 4.8,
]);
