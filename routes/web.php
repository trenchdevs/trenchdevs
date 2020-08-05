<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', 'HomeController@index');
});
