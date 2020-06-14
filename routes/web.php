<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', 'HomeController@index');
});

Route::get('test', function(){
    try {
        \Illuminate\Support\Facades\DB::connection();
        dd('connection made');
    }catch (Exception $exception) {
        dd($exception->getMessage());
    }

});
