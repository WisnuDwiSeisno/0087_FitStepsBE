<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RouteLog;

class RouteLogController extends Controller
{
    // Menyimpan rute
    public function store(Request $request)
    {
        $request->validate([
            'challenge_id' => 'nullable|exists:challenges,id',
            'date' => 'required|date',
            'path' => 'required|array', // array of coordinates
            'distance_km' => 'required|numeric',
            'duration_min' => 'required|integer|min:1',
            'avg_speed_kmh' => 'nullable|numeric',
        ]);

        $log = RouteLog::create([
            'user_id' => auth()->id(),
            'challenge_id' => $request->challenge_id,
            'date' => $request->date,
            'path' => json_encode($request->path),
            'distance_km' => $request->distance_km,
            'duration_min' => $request->duration_min,
            'avg_speed_kmh' => $request->avg_speed_kmh,
        ]);

        return response()->json([
            'message' => 'Route log saved successfully.',
            'data' => $log
        ]);
    }

    // Melihat semua rute milik user
    public function index()
    {
        $logs = RouteLog::where('user_id', auth()->id())->latest()->get();

        return response()->json($logs);
    }
}
