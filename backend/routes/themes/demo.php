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

Route::get('users', function() {
    return Inertia::render('Themes/TrenchDevsAdmin/Users/UsersIndex', [
        'data' => \App\Modules\Users\Models\User::query()->paginate(1),
    ]);
});

require __DIR__ . '/../auth.php';
