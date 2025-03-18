<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    return view('welcome');
});
