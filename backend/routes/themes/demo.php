<?php

use App\Modules\TrenchDevs\Http\Controllers\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/../auth.php';

//Route::get('/', function () {
//    return response()->json([
//        'message' => sprintf('Welcome to Demo page for this "%s" site. Nothing to do here.', site()->company_name ?? 'Demo'),
//        'success' => true,
//    ]);
//});

// Authentication Whitelist...
//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
//Route::post('login', 'Auth\LoginController@login');
//Route::post('logout', 'Auth\LoginController@logout')->name('logout');
//Route::get('logout', 'Auth\LoginController@logout')->name('logout_get');

//Route::middleware(['auth:web', 'verified'])->prefix('portal')->group(function () {
//    Route::get('home', [HomeController::class, 'index'])->name('portal.home');
//
//    require __DIR__ . '/../modules/users.php';
//});
