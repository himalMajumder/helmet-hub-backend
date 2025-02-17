<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProductController;

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

    Route::post('/product', [ProductController::class, 'index']);
});
