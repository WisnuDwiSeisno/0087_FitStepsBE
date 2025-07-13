<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Challenge;
use App\Models\ChallengeParticipation;
use App\Models\StepsLog;
use App\Models\Tip;
use App\Models\RouteLog;
use App\Models\Photo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Buat pengguna mentor & pelari
        $mentor = User::create([
            'name' => 'Mentor One',
            'email' => 'mentor@example.com',
            'password' => Hash::make('password'),
            'role' => 'mentor'
        ]);

        $pelari = User::create([
            'name' => 'Pelari One',
            'email' => 'pelari@example.com',
            'password' => Hash::make('password'),
            'role' => 'pelari'
        ]);

        // ✅ Buat challenge oleh mentor
        $challenge = Challenge::create([
            'title' => 'Lari 5KM',
            'description' => 'Tantangan untuk pelari pemula',
            'target_steps' => 6000,
            'duration_days' => 7,
            'created_by' => $mentor->id,
        ]);

        // ✅ Pelari join challenge
        ChallengeParticipation::create([
            'user_id' => $pelari->id,
            'challenge_id' => $challenge->id,
            'start_date' => now()->subDays(2),
            'status' => 'ongoing',
        ]);

        // ✅ Log langkah pelari
        StepsLog::create([
            'user_id' => $pelari->id,
            'steps' => 3200,
            'created_at' => now()->subDay(),
            'date' => now()->toDateString(),
        ]);

        // ✅ Tambah tips oleh mentor
        Tip::create([
            'title' => 'Tips Lari Pagi',
            'content' => 'Minum cukup air dan pemanasan sebelum mulai.',
            'mentor_id' => $mentor->id,
        ]);

        // ✅ Tracking rute pelari
        RouteLog::create([
            'user_id' => $pelari->id,
            'challenge_id' => $challenge->id,
            'date' => now()->toDateString(),
            'path' => json_encode([
                ['lat' => -6.9712, 'lng' => 107.6321],
                ['lat' => -6.9709, 'lng' => 107.6335]
            ]),
            'distance_km' => 1.5,
            'duration_min' => 20,
            'avg_speed_kmh' => 4.5,
        ]);

        // ✅ Upload foto bukti
        Photo::create([
            'user_id' => $pelari->id,
            'challenge_id' => $challenge->id,
            'file_path' => 'photos/sample.jpg',
            'caption' => 'Bukti lari hari ke-1'
        ]);
    }
}
