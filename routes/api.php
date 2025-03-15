<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\BikeModelController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'This application only for api',
    ]);
});

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthenticationController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', [AuthenticationController::class, 'logout']);
        Route::get('/user', [AuthenticationController::class, 'user']);
        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::get('/users/search', [UserController::class, 'search']);
        Route::put('/users/{user}/activate', [UserController::class, 'activate']);
        Route::put('/users/{user}/suspend', [UserController::class, 'suspended']);
        Route::apiResource('users', UserController::class);

        Route::get('/roles/permissions', [RoleController::class, 'rolesWithPermissions']);
        Route::get('/roles/search', [RoleController::class, 'search']);
        Route::apiResource('roles', RoleController::class);

        Route::get('/permissions', [PermissionController::class, 'index']);

        Route::get('/customer', [CustomerController::class, 'index']);
        Route::post('/customer/registration', [CustomerController::class, 'registration']);
        Route::delete('/customer/{customer}', [CustomerController::class, 'destroy']);

        Route::get('/bike-models/search', [BikeModelController::class, 'search']);
        Route::put('/bike-models/{bike_model}/activate', [BikeModelController::class, 'activate']);
        Route::put('/bike-models/{bike_model}/suspend', [BikeModelController::class, 'suspended']);
        Route::apiResource('bike-models', BikeModelController::class);

        Route::post('/products/import', [ProductController::class, 'storeImport']);
        Route::get('/products/import-template', [ProductController::class, 'importTemplate']);
        Route::put('/products/{product}/activate', [ProductController::class, 'activate']);
        Route::put('/products/{product}/suspend', [ProductController::class, 'suspended']);
        Route::apiResource('products', ProductController::class);

    });
});
