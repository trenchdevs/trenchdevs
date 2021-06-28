<?php

use Illuminate\Support\Facades\Route;

// Route::redirect('/', 'portal/home');
Route::middleware(['auth:web'])->group(function () {
    Route::view('home', 'themes.cloudcraft.home')->name('cloudcraft.home');
    Route::view('members', 'themes.cloudcraft.members')->name('cloudcraft.members');
});
Route::redirect('/', 'login');
