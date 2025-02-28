<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BikeModelController;

Route::get('/', function () {
    return response()->json([
        'This application only for api',
    ]);
});

Route::post('/login', [AuthenticationController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'user']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/customer/registration', [CustomerController::class, 'registration']);
    Route::delete('/customer/{customer}', [CustomerController::class, 'destroy']);

    Route::get('/bike-model', [BikeModelController::class, 'index']);
    Route::post('/bike-model', [BikeModelController::class, 'create']);
    Route::delete('/bike-model/{bike_model}', [BikeModelController::class, 'destroy']);

    Route::post('/product', [ProductController::class, 'index']);
});
