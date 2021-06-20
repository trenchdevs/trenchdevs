<?php

use Illuminate\Support\Facades\Route;

//Route::get('register', function(){
//
//});
Route::redirect('/', 'portal/home');
Route::middleware(['auth:web', 'verified'])->prefix('portal')->group(function () {
    Route::get('home', function () {
        dd('@portal home');
    });
});
