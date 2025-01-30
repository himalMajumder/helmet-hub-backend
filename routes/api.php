<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World',
    ]);
});

Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
