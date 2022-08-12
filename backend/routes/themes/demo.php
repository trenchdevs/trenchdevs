<?php


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Modules\Announcements\Http\Controllers\AnnouncementsController;
use App\Modules\Blogs\Http\Controllers\BlogsController;
use App\Modules\Photos\Http\Controllers\PhotosController;
use App\Modules\Projects\Http\Controllers\ProjectsController;
use App\Modules\TrenchDevs\Http\Controllers\PublicController;
use App\Modules\Users\Http\Controllers\UserPortfolioController;
use App\Modules\Users\Http\Controllers\UsersController;
use App\Public\Controllers\Blogs\PublicBlogsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/**
 * Admin: rendered via inertia
 */
Route::middleware(['web', 'auth:web', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', fn() => Inertia::render('Themes/TrenchDevsAdmin/Pages/Dashboard'))->middleware(['auth', 'verified'])->name('demo.dashboard');

    Route::get('account/change-password', [UsersController::class, 'showChangePasswordForm'])->name('demo.dashboard.users.showChangePasswordForm');
    Route::post('account/change-password', [UsersController::class, 'changePassword'])->name('demo.dashboard.users.changePassword');

    Route::post('portfolio/avatar', [UserPortfolioController::class, 'uploadAvatar'])->name('demo.dashboard.portfolio.uploadAvatar');
    Route::get('portfolio/{view}', [UserPortfolioController::class, 'show'])->name('demo.dashboard.portfolio.show');
    Route::post('portfolio/{view}', [UserPortfolioController::class, 'upsert'])->name('demo.dashboard.portfolio.upsert');

    Route::get('users', [UsersController::class, 'displayUsers'])->name('demo.dashboard.displayUsers');
    Route::get('users/upsert/{id?}', [UsersController::class, 'upsertForm'])->name('demo.dashboard.users.upsertForm');
    Route::post('users', [UsersController::class, 'upsertUser'])->name('demo.dashboard.users.upsertUser');
    Route::post('users/password-reset', [UsersController::class, 'passwordReset'])->name('demo.dashboard.users.passwordReset');

    Route::get('blogs', [BlogsController::class, 'displayBlogs'])->name('demo.dashboard.blogs');
    Route::get('blogs/upsert/{id?}', [BlogsController::class, 'upsertForm'])->name('demo.dashboard.blogs.upsertForm');
    Route::post('blogs/upsert', [BlogsController::class, 'upsertBlog'])->name('demo.dashboard.blogs.upsertBlog');
    Route::get('blogs/preview/{id}', [BlogsController::class, 'preview'])->name('demo.dashboard.blogs.preview');

    Route::get('photos', [PhotosController::class, 'displayPhotos'])->name('demo.dashboard.photos');
    Route::post('photos/upload', [PhotosController::class, 'upload'])->name('demo.dashboard.photos.upload');
    Route::post('photos/delete/{id}', [PhotosController::class, 'delete'])->name('demo.dashboard.photos.delete');

    Route::get('announcements', [AnnouncementsController::class, 'displayAnnouncements'])->name('demo.dashboard.announcements');
    Route::get('announcements/create', [AnnouncementsController::class, 'displayCreateForm'])->name('demo.dashboard.announcements.displayCreateForm');
    Route::post('announcements/create', [AnnouncementsController::class, 'createAnnouncement'])->name('demo.dashboard.announcements.createAnnouncement');

    Route::get('projects', [ProjectsController::class, 'displayProjects'])->name('demo.dashboard.projects.displayProjects');
});


Route::middleware('web')->group(function () {

    // auth routes
    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('demo.register');
        Route::post('register', [RegisteredUserController::class, 'store']);
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('demo.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('demo.password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('demo.password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('demo.password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('demo.password.update');
    });

    Route::middleware('auth')->group(function () {
        Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('demo.verification.notice');
        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('demo.verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('demo.verification.send');
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('demo.password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('demo.logout');
    });


    /**
     * Public Rendered Pages (Blade)
     */
    Route::get('blogs', [PublicBlogsController::class, 'index'])->name('demo.public.blogs');

    // start - public documents
    Route::view('documents/privacy', 'documents.privacy')->name('demo.documents.privacy');
    Route::view('documents/tnc', 'documents.tnc')->name('demo.documents.tnc');
    // end - public documents

    Route::get('/', [PublicController::class, 'index'])->name('demo.public.home');
    Route::get('{slug}', [PublicController::class, 'show'])->name('demo.public.show');
});
