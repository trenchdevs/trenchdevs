<?php

use App\Http\Controllers\HighStorage\UserMetricsController;
use Illuminate\Support\Facades\Route;


Route::get('user-metrics', [UserMetricsController::class, 'index'])->name('api-user-metrics');

