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

}
