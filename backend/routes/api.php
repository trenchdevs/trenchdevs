<?php

use App\Modules\Activities\Http\Controllers\ActivitiesController;
use App\Modules\Stories\Http\Controllers\ProductReactionsController;
use App\Modules\Stories\Http\Controllers\ProductStoriesController;
use App\Modules\Stories\Http\Controllers\Stories;
use App\Modules\Stories\Http\Controllers\StoryResponsesController;
use App\Http\Controllers\AuthController;
use App\Modules\Products\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ---------- Start Authentication Endpoints ---------- //
Route::group(['prefix' => 'auth'], function () {

    Route::post('register', [AuthController::class, 'register'])->name('api.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::post('me', [AuthController::class, 'me'])->name('api.me');
    Route::post('sud', [AuthController::class, 'sud']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('refresh', [AuthController::class, 'refreshToken'])->name('api.refresh');
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    // ---------- Start Notes ---------- //
    //Route::post('notes', [ApiNotes::class, 'index']);
    // Route::post('notes/upsert', [ApiNotes::class, 'upsert']);

    // ---------- End Notes ---------- //

});

// ---------- End Authentication Endpoints ---------- //

Route::post('activities', [ActivitiesController::class, 'store'])->middleware(['ip-restricted']);
