<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StepsLog;
use App\Models\Challenge;
use App\Models\ChallengeParticipation;



class StepsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $logs = StepsLog::where('user_id', $user->id)->orderBy('date', 'desc')->get();

        return response()->json($logs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'steps' => 'required|integer|min:0',
            'distance_km' => 'nullable|numeric|min:0'
        ]);

        $userId = auth()->id();

        // 1. Simpan / update log langkah harian
        $log = StepsLog::updateOrCreate(
            ['user_id' => $userId, 'date' => $request->date],
            ['steps' => $request->steps, 'distance_km' => $request->distance_km]
        );

        // 2. Cari challenge yang sedang diikuti dan masih ongoing
        $participation = ChallengeParticipation::where('user_id', $userId)
            ->where('status', 'ongoing')
            ->orderBy('start_date', 'desc') // ambil yang terbaru
            ->first();

        if ($participation) {
            // 3. Update total progress langkah
            $participation->progress_steps += $request->steps;

            // 4. Cek apakah sudah selesai
            $target = Challenge::find($participation->challenge_id)->target_steps;

            if ($participation->progress_steps >= $target) {
                $participation->status = 'completed';
                $participation->completed_at = now();
            }

            $participation->save();
        }

        return response()->json([
            'message' => 'Steps log saved and challenge progress updated',
            'data' => $log
        ]);
    }

    public function weeklyStats()
    {
        $user = auth()->user();

        $data = [];
        $today = now()->startOfDay();

        // Loop 7 hari ke belakang
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i)->toDateString();

            $total = StepsLog::where('user_id', $user->id)
                ->whereDate('created_at', $date)
                ->sum('steps');

            $data[] = [
                'date' => $date,
                'steps' => $total
            ];
        }

        return response()->json($data);
    }
}
