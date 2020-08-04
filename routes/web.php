<?php

if (env('APP_ENV') === 'production') {
    URL::forceSchema('https');
}

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', 'HomeController@index');
});
