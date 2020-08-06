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

    // Users

//    Route::get('api/admin/users', function(){
//       return \App\User::all();
//    });
    Route::get('admin/users/create', 'Admin\UsersController@create')->name('users.create');
    Route::post('admin/users/upsert', 'Admin\UsersController@upsert')->name('users.upsert');
    Route::get('admin/users/{id}', 'Admin\UsersController@edit')->name('users.edit');
    Route::get('admin/users', 'Admin\UsersController@index')->name('users.index');
//    Route::resource('/admin/users', 'Admin\UsersController');
});
