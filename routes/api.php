<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginRequest;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World',
    ]);
});

Route::post('/login', function (LoginRequest $request) {
    return response()->json([
        'message'    => 'Hello World',
        'validation' =>1,
    ]);
});
