<?php

namespace App\Services;

use App\Models\Challenge;
use Illuminate\Support\Facades\Validator;
use App\Models\ChallengeParticipation;
use Carbon\Carbon;
use Illuminate\Http\Request;



class ChallengeService
{
    public function getAll()
    {
        return Challenge::with('creator')->latest()->get();
    }

    public function create($request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'target_steps' => 'required|integer|min:1',
            'duration_days' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Validasi bahwa user yang membuat adalah mentor
        if (auth()->user()->role !== 'mentor') {
            return response()->json(['error' => 'Only mentors can create challenges'], 403);
        }

        $challenge = Challenge::create([
            'title' => $request->title,
            'description' => $request->description,
            'target_steps' => $request->target_steps,
            'duration_days' => $request->duration_days,
            'created_by' => auth()->id(),
        ]);

        return response()->json(['message' => 'Challenge created', 'data' => $challenge]);
    }

    public function find($id)
    {
        $challenge = Challenge::with('creator')->find($id);

        if (!$challenge) {
            return response()->json(['error' => 'Challenge not found'], 404);
        }

        return response()->json($challenge);
    }

    public function joinChallenge($challengeId)
    {
        $user = auth()->user();

        if ($user->role !== 'pelari') {
            return response()->json(['error' => 'Only pelari can join challenges'], 403);
        }

        $challenge = Challenge::find($challengeId);
        if (!$challenge) {
            return response()->json(['error' => 'Challenge not found'], 404);
        }

        $exists = ChallengeParticipation::where('user_id', $user->id)
            ->where('challenge_id', $challengeId)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already joined this challenge']);
        }

        $participation = ChallengeParticipation::create([
            'user_id' => $user->id,
            'challenge_id' => $challengeId,
            'start_date' => Carbon::now()->toDateString()
        ]);

        return response()->json([
            'message' => 'Successfully joined challenge',
            'data' => $participation
        ]);
    }

    public function getUserChallenges()
    {
        $user = auth()->user();

        $challenges = ChallengeParticipation::with('challenge')
            ->where('user_id', $user->id)
            ->whereHas('challenge') // pastikan relasi valid
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json([
            'ongoing' => $challenges->where('status', 'ongoing')->values(),
            'completed' => $challenges->where('status', 'completed')->values(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $challenge = \App\Models\Challenge::findOrFail($id);

        // Optional: validasi request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_steps' => 'required|integer',
            'duration_days' => 'required|integer',
        ]);

        $challenge->update($validated);

        return response()->json(['message' => 'Challenge berhasil diupdate', 'data' => $challenge]);
    }

}
