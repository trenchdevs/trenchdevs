<?php

/*
|--------------------------------------------------------------------------
| Web API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "web" middleware group and "api" domain. Enjoy building your API!
| eg. trenchdevs.org/webapi/*
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('webapi')->group(function () {
    request()->headers->set('Accept', 'application/json');

//    if (env('APP_ENV') !== 'production') {
//        // can be used for testing on react app
//        Auth::guard('web')->loginUsingId(2);
//    }

    Route::middleware(['auth:web'])->group(function () {

        Route::get('blogs', 'Blogs\BlogsController@index');

        Route::get('me', function () {
            return response()->json(auth()->user());
        });

    });

});

