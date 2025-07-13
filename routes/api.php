<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChallengeController;
use App\Http\Controllers\Api\StepsController;
use App\Http\Controllers\Api\TipController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\RouteLogController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PhotoController;




// Define API routes for authentication
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
    Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);
});

// Route to get the dashboard, only accessible to authenticated users
Route::middleware('auth:api')->get('dashboard', [DashboardController::class, 'index']);


// Route to get user's challenges, only accessible to authenticated users
Route::middleware('auth:api')->prefix('challenges')->group(function () {
    Route::get('/my', [ChallengeController::class, 'myChallenges']);
});

// Route to get challenge history, only accessible to authenticated users
Route::middleware('auth:api')->get('challenges/history', [ChallengeController::class, 'history']);

// Define API routes for challenges
Route::middleware('auth:api')->prefix('challenges')->group(function () {
    Route::get('/', [ChallengeController::class, 'index']);       // semua challenge
    Route::post('/', [ChallengeController::class, 'store']);      // buat challenge (mentor)
    Route::get('/{id}', [ChallengeController::class, 'show']);    // detail challenge
    Route::put('/{id}', [ChallengeController::class, 'update']); // ✅ Tambah
    Route::delete('/{id}', [ChallengeController::class, 'destroy']); // hapus challenge (mentor)
});

// Route to join a challenge, only accessible to authenticated users
Route::middleware('auth:api')->prefix('challenges')->group(function () {
    Route::post('{id}/join', [ChallengeController::class, 'join']);
});

// Route to get participants of a challenge, only accessible to authenticated users
Route::middleware('auth:api')->get('challenges/{id}/participants', [ChallengeController::class, 'participants']);


// Route to unjoin a challenge, only accessible to authenticated users
Route::middleware('auth:api')->delete('challenges/{id}/unjoin', [ChallengeController::class, 'unjoin']);


// Route to get all steps logs, only accessible to authenticated users
Route::middleware('auth:api')->prefix('steps')->group(function () {
    Route::get('/', [StepsController::class, 'index']);     // Lihat semua log
    Route::post('/', [StepsController::class, 'store']);    // Tambah log
});

// Route to get weekly steps stats, only accessible to authenticated users
Route::middleware('auth:api')->get('steps/weekly', [StepsController::class, 'weeklyStats']);

// Define API routes for tips
Route::middleware('auth:api')->prefix('tips')->group(function () {
    Route::get('/', [TipController::class, 'index']); // semua tips
    Route::post('/', [TipController::class, 'store']); // hanya mentor
    Route::put('{id}', [TipController::class, 'update']);   // ✅ update tip
    Route::delete('{id}', [TipController::class, 'destroy']); // ✅ delete tip
});

// Route to get tips by category, only accessible to authenticated users
Route::middleware('auth:api')->prefix('routes')->group(function () {
    Route::post('/', [RouteLogController::class, 'store']);  // simpan rute
    Route::get('/', [RouteLogController::class, 'index']);   // lihat semua rute user
});

// Route to get user profile, only accessible to authenticated users
Route::middleware('auth:api')->get('profile', [UserController::class, 'profile']);
Route::middleware('auth:api')->put('profile', [UserController::class, 'update']);


// Define API routes for photo management
Route::middleware('auth:api')->prefix('photos')->group(function () {
    Route::post('/', [PhotoController::class, 'store']);
    Route::get('/', [PhotoController::class, 'index']);
});


