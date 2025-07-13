<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'caption' => 'nullable|string',
            'challenge_id' => 'nullable|exists:challenges,id',
        ]);

        $path = $request->file('photo')->store('photos', 'public');

        $photo = Photo::create([
            'user_id' => auth()->id(),
            'challenge_id' => $request->challenge_id,
            'file_path' => $path,
            'caption' => $request->caption,
        ]);

        return response()->json([
            'message' => 'Photo uploaded successfully',
            'data' => [
                'url' => asset('storage/' . $photo->file_path),
                'caption' => $photo->caption,
                'challenge_id' => $photo->challenge_id
            ]
        ]);
    }

    public function index()
    {
        $photos = Photo::where('user_id', auth()->id())->latest()->get();

        return response()->json($photos);
    }
}
