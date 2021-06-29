<?php

use App\Http\Controllers\Api\ApiActivities;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:web'])->group(function () {
    Route::view('home', 'themes.cloudcraft.home');
});
Route::redirect('/', 'login');
