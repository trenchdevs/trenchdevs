<?php

use App\Modules\Emails\Http\Controllers\EmailPreferencesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Routes here are globally accessible by all sites.
 */

Route::get('emails/unsubscribe', [EmailPreferencesController::class, 'showUnsubscribeForm'])->name('notifications.emails.showUnsubscribeForm');
Route::post('emails/unsubscribe', [EmailPreferencesController::class, 'unsubscribe'])->name('notifications.emails.unsubscribe');
