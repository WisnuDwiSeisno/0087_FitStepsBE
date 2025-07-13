<?php

namespace Database\Seeders;

use App\Models\Challenge;

Challenge::create([
    'title' => 'Lari 5KM',
    'description' => 'Tantangan lari jarak jauh',
    'target_steps' => 6000,
    'duration_days' => 7,
    'created_by' => 1, // Mentor ID
]);
