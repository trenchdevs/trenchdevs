<?php

use Illuminate\Support\Facades\Route;

// Authentication
Auth::routes(['register' => false]);

Route::middleware(['auth:web'])->group(function () {

    Route::prefix('portal')->group(function(){
        Route::view('home', 'themes.sjp.home')->name('sjp.home');
        Route::view('members', 'themes.sjp.members')->name('sjp.members');
    });

});

Route::redirect('/', 'login');
