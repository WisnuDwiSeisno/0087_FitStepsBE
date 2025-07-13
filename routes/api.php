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
