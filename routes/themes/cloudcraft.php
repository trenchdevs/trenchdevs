<?php

use Illuminate\Support\Facades\Route;

// Route::redirect('/', 'portal/home');
Route::middleware(['auth:web'])->group(function () {
    Route::view('home', 'themes.cloudcraft.home');
});
Route::redirect('/', 'login');
