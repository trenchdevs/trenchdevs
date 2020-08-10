<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

Route::get('/', 'PublicController@index');

Auth::routes(['verify' => true]);

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index');

    // START - users
    Route::get('admin/users/create', 'Admin\UsersController@create')->name('users.create');
    Route::post('admin/users/upsert', 'Admin\UsersController@upsert')->name('users.upsert');
    Route::post('admin/users/password_reset', 'Admin\UsersController@passwordReset')->name('users.password_reset');
    Route::get('admin/users/{id}', 'Admin\UsersController@edit')->name('users.edit');
    Route::get('admin/users', 'Admin\UsersController@index')->name('users.index');
    // End - users

    // START - mailers
    Route::get('emails/generic', 'EmailTester@genericMail');
    // END - mailers

});

Route::get('{username}', 'PortfolioController@show');
Route::get('emails/test/{view}', 'EmailTester@test');
Route::get('emails/testsend', 'EmailTester@testSend');
Route::post('aws/sns', 'AwsController@sns');
