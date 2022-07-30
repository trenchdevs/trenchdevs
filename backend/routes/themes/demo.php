<?php

use App\Modules\TrenchDevs\Http\Controllers\PublicController;
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
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/../auth.php';
