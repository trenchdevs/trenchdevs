<?php

use App\Modules\Blogs\Http\Controllers\BlogsController;
use App\Modules\Photos\Http\Controllers\PhotosController;
use App\Modules\TrenchDevs\Http\Controllers\PublicController;
use App\Modules\Users\Http\Controllers\UserPortfolioController;
use App\Modules\Users\Http\Controllers\UsersController;
use App\Public\Controllers\Blogs\PublicBlogsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/**
 * Admin: rendered via inertia
 */
Route::middleware(['auth:web', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', fn() => Inertia::render('Themes/TrenchDevsAdmin/Pages/Dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('account/change-password', [UsersController::class, 'showChangePasswordForm'])->name('dashboard.users.showChangePasswordForm');
    Route::post('account/change-password', [UsersController::class, 'changePassword'])->name('dashboard.users.changePassword');

    Route::post('portfolio/avatar', [UserPortfolioController::class, 'uploadAvatar'])->name('dashboard.portfolio.uploadAvatar');
    Route::get('portfolio/{view}', [UserPortfolioController::class, 'show'])->name('dashboard.portfolio.show');
    Route::post('portfolio/{view}', [UserPortfolioController::class, 'upsert'])->name('dashboard.portfolio.upsert');

    Route::get('users', [UsersController::class, 'displayUsers'])->name('dashboard.users');
    Route::get('users/upsert/{id?}', [UsersController::class, 'upsertForm'])->name('dashboard.users.upsertForm');
    Route::post('users', [UsersController::class, 'upsert'])->name('dashboard.users.upsert');
    Route::post('users/password-reset', [UsersController::class, 'passwordReset'])->name('dashboard.users.passwordReset');

    Route::get('blogs', [BlogsController::class, 'displayBlogs'])->name('dashboard.blogs');
    Route::get('blogs/upsert/{id?}', [BlogsController::class, 'upsertForm'])->name('dashboard.blogs.upsertForm');
    Route::post('blogs/upsert', [BlogsController::class, 'upsertBlog']);
    Route::get('blogs/preview/{id}', [BlogsController::class, 'preview']);

    Route::get('photos', [PhotosController::class, 'displayPhotos'])->name('dashboard.photos');
    Route::post('photos/upload', [PhotosController::class, 'upload'])->name('dashboard.photos.upload');
    Route::post('photos/delete/{id}', [PhotosController::class, 'delete'])->name('dashboard.photos.delete');
});


require __DIR__ . '/../auth.php';


/**
 * Public Rendered Pages (Blade)
 */
Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs');

// start - public documents
Route::view('documents/privacy', 'documents.privacy')->name('documents.privacy');
Route::view('documents/tnc', 'documents.tnc')->name('documents.tnc');
// end - public documents

Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('{slug}', [PublicController::class, 'show'])->name('public.show');
