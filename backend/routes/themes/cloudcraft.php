<?php

use App\Modules\Activities\Http\Controllers\ActivitiesController;
use Illuminate\Support\Facades\Route;

require __DIR__  . '/../trenchdevs_dashboard.php';

Route::prefix('api')->middleware('api')->group(function () {
    Route::post('activities', [ActivitiesController::class, 'store'])->middleware(['ip-restricted']);
});
