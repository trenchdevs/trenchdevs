<?php

use App\Modules\TrenchDevs\Http\Controllers\PublicController;
use App\Modules\Users\Http\Controllers\UsersController;
use App\Public\Controllers\Blogs\PublicBlogsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/**
 * Public: rendered via blade
 */
Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs');
Route::get('/', [PublicController::class, 'index'])->name('public.home');

// start - public documents
Route::view('documents/privacy', 'documents.privacy')->name('documents.privacy');
Route::view('documents/tnc', 'documents.tnc')->name('documents.tnc');
// end - public documents

/**
 * Admin: rendered via inertia
 */
Route::middleware(['auth:web', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('users', [UsersController::class, 'index'])->name('dashboard.users');
    Route::get('users/upsert/{id?}', [UsersController::class, 'upsertForm'])->name('dashboard.users.upsertForm');
    Route::post('users', [UsersController::class, 'upsertPost'])->name('dashboard.users.upsertPost');
    Route::post('users/password-reset', [UsersController::class, 'passwordReset'])->name('dashboard.users.passwordReset');
});


require __DIR__ . '/../auth.php';
