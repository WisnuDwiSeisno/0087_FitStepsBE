<?php

namespace Database\Seeders;

use App\Models\ChallengeParticipation;

ChallengeParticipation::create([
    'user_id' => 2, // Pelari
    'challenge_id' => 1,
    'start_date' => now()->subDays(2),
    'status' => 'ongoing',
]);
