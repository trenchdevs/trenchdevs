<?php

use App\Modules\Announcements\Http\Controllers\AnnouncementsController;
use App\Modules\Blogs\Http\Controllers\BlogsController;
use App\Modules\Blogs\Http\Controllers\PublicBlogsController;
use App\Modules\Photos\Http\Controllers\PhotosController;
use App\Modules\Projects\Http\Controllers\ProjectsController;
use App\Modules\Themes\TrenchDevs\Http\Controllers\DashboardController;
use App\Modules\Users\Http\Controllers\UserPortfolioController;
use App\Modules\Users\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/**
 * Admin: rendered via inertia
 */
Route::middleware(['web', 'auth:web', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', fn() => Inertia::render('Themes/TrenchDevsAdmin/Pages/Dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('account/change-password', [UsersController::class, 'showChangePasswordForm'])->name('dashboard.users.showChangePasswordForm');
    Route::post('account/change-password', [UsersController::class, 'changePassword'])->name('dashboard.users.changePassword');

    Route::post('portfolio/avatar', [UserPortfolioController::class, 'uploadAvatar'])->name('dashboard.portfolio.uploadAvatar');
    Route::get('portfolio/{view}', [UserPortfolioController::class, 'show'])->name('dashboard.portfolio.show');
    Route::post('portfolio/{view}', [UserPortfolioController::class, 'upsert'])->name('dashboard.portfolio.upsert');

    Route::get('users', [UsersController::class, 'displayUsers'])->name('dashboard.displayUsers');
    Route::get('users/upsert/{id?}', [UsersController::class, 'upsertForm'])->name('dashboard.users.upsertForm');
    Route::post('users', [UsersController::class, 'upsertUser'])->name('dashboard.users.upsertUser');
    Route::post('users/password-reset', [UsersController::class, 'passwordReset'])->name('dashboard.users.passwordReset');

    Route::get('blogs', [BlogsController::class, 'displayBlogs'])->name('dashboard.blogs');
    Route::get('blogs/upsert/{id?}', [BlogsController::class, 'upsertForm'])->name('dashboard.blogs.upsertForm');
    Route::post('blogs/upsert', [BlogsController::class, 'upsertBlog'])->name('dashboard.blogs.upsertBlog');
    Route::get('blogs/preview/{id}', [BlogsController::class, 'preview'])->name('dashboard.blogs.preview');

    Route::get('photos', [PhotosController::class, 'displayPhotos'])->name('dashboard.photos');
    Route::post('photos/upload', [PhotosController::class, 'upload'])->name('dashboard.photos.upload');
    Route::post('photos/delete/{id}', [PhotosController::class, 'delete'])->name('dashboard.photos.delete');

    Route::get('announcements', [AnnouncementsController::class, 'displayAnnouncements'])->name('dashboard.announcements');
    Route::get('announcements/create', [AnnouncementsController::class, 'displayCreateForm'])->name('dashboard.announcements.displayCreateForm');
    Route::post('announcements/create', [AnnouncementsController::class, 'createAnnouncement'])->name('dashboard.announcements.createAnnouncement');

    Route::get('projects', [ProjectsController::class, 'displayProjects'])->name('dashboard.projects.displayProjects');
});


Route::middleware('web')->group(function(){

    // auth routes
    require __DIR__ . '/../auth.php';

    /**
     * Public Rendered Pages (Blade)
     */
    Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs');

    // start - public documents
    Route::view('documents/privacy', 'themes.trenchdevs.pages.documents.privacy')->name('documents.privacy');
    Route::view('documents/tnc', 'themes.trenchdevs.pages.documents.tnc')->name('documents.tnc');
    // end - public documents

    Route::get('/', [DashboardController::class, 'index'])->name('public.home');
    Route::get('{slug}', [DashboardController::class, 'show'])->name('public.show');
});
