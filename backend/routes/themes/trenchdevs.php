<?php

use App\Modules\Blogs\Http\Controllers\BlogsController;
use App\Modules\TrenchDevs\Http\Controllers\PublicController;
use App\Modules\Users\Http\Controllers\UserPortfolioController;
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
    Route::get('/', fn() => Inertia::render('Themes/TrenchDevsAdmin/Pages/Dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('account/change-password', [UsersController::class, 'showChangePasswordForm'])->name('dashboard.users.showChangePasswordForm');
    Route::post('account/change-password', [UsersController::class, 'changePassword'])->name('dashboard.users.changePassword');

    Route::get('portfolio/{view}', [UserPortfolioController::class, 'show'])->name('dashboard.portfolio.show');
    Route::post('portfolio/{view}', [UserPortfolioController::class, 'upsert'])->name('dashboard.portfolio.upsert');

    Route::get('users', [UsersController::class, 'index'])->name('dashboard.users');
    Route::get('users/upsert/{id?}', [UsersController::class, 'upsertForm'])->name('dashboard.users.upsertForm');
    Route::post('users', [UsersController::class, 'upsertPost'])->name('dashboard.users.upsertPost');
    Route::post('users/password-reset', [UsersController::class, 'passwordReset'])->name('dashboard.users.passwordReset');

    Route::get('blogs', [BlogsController::class, 'displayBlogs'])->name('dashboard.blogs');
    Route::get('blogs/upsert/{id?}', [BlogsController::class, 'upsertForm'])->name('dashboard.blogs.upsertForm');
    Route::post('blogs/upsert', [BlogsController::class, 'upsertBlog']);
    Route::get('blogs/preview/{id}', [BlogsController::class, 'preview']);
});


require __DIR__ . '/../auth.php';
