<?php

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AwsController;
use App\Http\Controllers\Blogs\PublicBlogsController;
use App\Http\Controllers\EmailTester;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Notifications\EmailPreferencesController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects\ProjectsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SuperAdmin\CommandsController;
use App\Http\Controllers\Shop\ProductsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

//if (env('APP_ENV') === 'production') {
//    URL::forceScheme('https');
//}

$baseUrl = get_base_url();

if (empty($baseUrl)) {
    throw new Exception("Base url not found.");
}

// Auth::routes(['verify' => true]);

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
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


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



