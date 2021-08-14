<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

// Authentication
Auth::routes(['register' => false]);

// TODO: make this a flag & add to RouteServiceProvider instead
Route::middleware(['auth:web'])->group(function () {
    Route::get('/{any}', function () {
        return File::get(public_path() . '/alph/index.html');
    })->where('any', '.*');

});

// if user is not authenticated just redirect to login page
Route::redirect('/', 'login');
