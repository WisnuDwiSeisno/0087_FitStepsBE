<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tip;

class TipController extends Controller
{
    public function index()
    {
        return Tip::with('creator')->latest()->get();
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== 'mentor') {
            return response()->json(['error' => 'Only mentor can post tips'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $tip = Tip::create([
            'title' => $request->title,
            'content' => $request->content,
            'mentor_id' => $user->id
        ]);

        return response()->json(['message' => 'Tip created', 'data' => $tip]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $tip = Tip::find($id);

        if (!$tip) {
            return response()->json(['error' => 'Tip not found'], 404);
        }

        if ($user->role !== 'mentor' || $user->id !== $tip->mentor_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $tip->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response()->json(['message' => 'Tip updated', 'data' => $tip]);
    }
    public function destroy($id)
    {
        $user = auth()->user();
        $tip = Tip::find($id);

        if (!$tip) {
            return response()->json(['error' => 'Tip not found'], 404);
        }

        if ($user->role !== 'mentor' || $user->id !== $tip->mentor_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $tip->delete();

        return response()->json(['message' => 'Tip deleted']);
    }

}
