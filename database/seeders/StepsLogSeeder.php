<?php

namespace Database\Seeders;

use App\Models\StepsLog;

StepsLog::create([
    'user_id' => 2,
    'steps' => 3200,
    'created_at' => now()->subDays(1),
]);
