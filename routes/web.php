<?php

use App\Domains\Aws\Http\Controllers\AwsController;
use App\Http\Controllers\EmailTester;
use App\Domains\Emails\Http\Controllers\EmailPreferencesController;
use Illuminate\Support\Facades\Route;

$baseUrl = get_base_url();

if (empty($baseUrl)) {
    throw new Exception("Base url not found.");
}

/*
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', 'Auth\LoginController@logout')->name('logout_get');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/


// start - public documents
Route::view('documents/privacy', 'documents.privacy')->name('documents.privacy');
Route::view('documents/tnc', 'documents.tnc')->name('documents.tnc');
// end - public documents


// start - public email endpoints
Route::get('emails/unsubscribe', [EmailTester::class, 'test']);
Route::get('emails/testsend', [EmailTester::class, 'testSend']);

Route::get('emails/unsubscribe', [EmailPreferencesController::class, 'showUnsubscribeForm'])->name('notifications.emails.showUnsubscribeForm');
Route::post('emails/unsubscribe', [EmailPreferencesController::class, 'unsubscribe'])->name('notifications.emails.unsubscribe');
// end - public email endpoints
Route::post('aws/sns', [AwsController::class, 'sns']);



