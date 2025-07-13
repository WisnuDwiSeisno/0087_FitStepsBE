<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StepsLog;
use App\Models\ChallengeParticipation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role !== 'pelari') {
            return response()->json(['error' => 'Only pelari can access dashboard'], 403);
        }

        $today = now()->toDateString();

        // Total langkah hari ini
        $totalStepsToday = StepsLog::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->sum('steps');

        // Estimasi jarak tempuh (1 langkah = 0.000762 km)
        $distanceKm = round($totalStepsToday * 0.000762, 2);

        // Jumlah tantangan aktif
        $activeChallenges = ChallengeParticipation::where('user_id', $user->id)
            ->where('status', 'ongoing')
            ->count();

        return response()->json([
            'date' => $today,
            'total_steps' => $totalStepsToday,
            'distance_km' => $distanceKm,
            'active_challenges' => $activeChallenges
        ]);
    }
}
