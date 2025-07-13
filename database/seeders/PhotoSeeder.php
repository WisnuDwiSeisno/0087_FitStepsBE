<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Photo;

Photo::create([
    'user_id' => 2,
    'challenge_id' => 1,
    'file_path' => 'photos/sample.jpg',
    'caption' => 'Setelah lari hari pertama',
]);
