<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\BikeModelController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/bike-model/search', [BikeModelController::class, 'search']);
    Route::post('/bike-model', [BikeModelController::class, 'create']);
    Route::get('/bike-model/{bike_model}', [BikeModelController::class, 'edit']);
    Route::put('/bike-model/{bike_model}', [BikeModelController::class, 'update']);
    Route::delete('/bike-model/{bike_model}', [BikeModelController::class, 'destroy']);
    Route::put('/bike-model/{bike_model}/activate', [BikeModelController::class, 'activate']);
    Route::put('/bike-model/{bike_model}/suspend', [BikeModelController::class, 'suspended']);

    Route::post('/product', [ProductController::class, 'index']);


});
