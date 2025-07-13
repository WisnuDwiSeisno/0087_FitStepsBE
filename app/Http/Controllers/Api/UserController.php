<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StepsLog;
use App\Models\ChallengeParticipation;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();

        $totalSteps = StepsLog::where('user_id', $user->id)->sum('steps');

        $completedChallenges = ChallengeParticipation::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'total_steps' => $totalSteps,
            'challenges_completed' => $completedChallenges
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully.',
            'name' => $user->name
        ]);
    }
}
