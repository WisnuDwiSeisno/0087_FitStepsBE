<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\ChallengeService;

class ChallengeController extends Controller
{
    protected $challenge;

    public function __construct(ChallengeService $challenge)
    {
        $this->challenge = $challenge;
    }

    public function index()
    {
        return $this->challenge->getAll();
    }

    public function store(Request $request)
    {
        return $this->challenge->create($request);
    }

    public function show($id)
    {
        return $this->challenge->find($id);
    }
    public function join($id)
    {
        return $this->challenge->joinChallenge($id);
    }
    public function myChallenges()
    {
        return $this->challenge->getUserChallenges();
    }
    public function history()
    {
        $user = auth()->user();

        if ($user->role !== 'pelari') {
            return response()->json(['error' => 'Only pelari can access history'], 403);
        }

        $completed = \App\Models\ChallengeParticipation::with('challenge')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->get();

        return response()->json($completed);
    }
    public function unjoin($id)
    {
        $user = auth()->user();

        if ($user->role !== 'pelari') {
            return response()->json(['error' => 'Only pelari can unjoin challenge'], 403);
        }

        $participation = \App\Models\ChallengeParticipation::where('user_id', $user->id)
            ->where('challenge_id', $id)
            ->where('status', 'ongoing')
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'You are not in this ongoing challenge'], 404);
        }

        $participation->delete();

        return response()->json(['message' => 'You have unjoined the challenge']);
    }
    public function participants($id)
    {
        $mentor = auth()->user();

        if ($mentor->role !== 'mentor') {
            return response()->json(['error' => 'Only mentors can view participants'], 403);
        }

        $challenge = \App\Models\Challenge::where('id', $id)
            ->where('created_by', $mentor->id)
            ->first();

        if (!$challenge) {
            return response()->json(['error' => 'Challenge not found or not owned by you'], 404);
        }

        $participants = \App\Models\ChallengeParticipation::with('user')
            ->where('challenge_id', $id)
            ->get();

        return response()->json([
            'challenge_title' => $challenge->title,
            'participants' => $participants->map(function ($p) {
                return [
                    'name' => $p->user->name,
                    'email' => $p->user->email,
                    'status' => $p->status,
                    'start_date' => $p->start_date,
                    'progress_steps' => $p->progress_steps
                ];
            })
        ]);
    }
    public function update(Request $request, $id)
    {
        return $this->challenge->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->challenge->delete($id);
    }

}

