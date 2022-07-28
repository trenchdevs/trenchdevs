<?php

use App\Domains\Announcements\Http\Controllers\AnnouncementsController;
use App\Domains\Blogs\Http\Controllers\BlogsController;
use App\Domains\Photos\Http\Controllers\AdminPhotoAlbumsController;
use App\Domains\Photos\Http\Controllers\AdminPhotosController;
use App\Domains\TrenchDevs\Http\Controllers\HomeController;
use App\Domains\Users\Http\Controllers\PortfolioController;
use App\Domains\Users\Http\Controllers\UsersController;
use App\Public\Controllers\Blogs\PublicBlogsController;
use App\Public\Controllers\Pages\PublicPagesController;
use App\Public\Controllers\PublicHomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['ip-restricted'])->group(function () {
    Auth::routes(['verify' => true, 'register' => true]);

// start - blogs - public
//Route::get('b/{id}', [PublicBlogsController::class, 'show'])->name('blogs.show');
// end - blogs -public

    Route::middleware(['auth:web', 'verified'])->prefix('portal')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('portal.home');


        // START - users
        Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('users/upsert', [UsersController::class, 'upsert'])->name('users.upsert');
        Route::post('users/password_reset', [UsersController::class, 'passwordReset'])->name('users.password_reset');
        Route::get('users', [UsersController::class, 'index'])->name('users.index');
        // change password
        Route::post('users/change_password', [UsersController::class, 'changePassword'])->name('users.change_password');
        Route::get('security', [PortfolioController::class, 'showSecurity'])->name('portfolio.security');
        Route::get('users/{id}', [UsersController::class, 'edit'])->name('users.edit');

        // End - users

        // Start - Photos
        Route::post('photos/upload', [AdminPhotosController::class, 'upload'])->name('admin.photos.upload');
        Route::post('photos/delete/{id}', [AdminPhotosController::class, 'delete'])->name('admin.photos.delete');
        Route::get('photos', [AdminPhotosController::class, 'index'])->name('admin.photos.index');
        Route::get('photos/albums', [AdminPhotoAlbumsController::class, 'getIndex'])->name('admin.photos.albums');
        Route::get('photos/albums/upsert/{id?}', [AdminPhotoAlbumsController::class, 'getUpsert'])->name('admin.photos.albums.upsert');
        Route::post('photos/albums/upsert', [AdminPhotoAlbumsController::class, 'postUpsert'])->name('admin.photos.albums.post_upsert');
        Route::post('photos/albums/associate', [AdminPhotoAlbumsController::class, 'postAssociate'])->name('admin.photos.albums.associate');
        Route::post('photos/albums/disassociate', [AdminPhotoAlbumsController::class, 'postDisassociate'])->name('admin.photos.albums.disassociate');
        // End - Photos

        // Start - Announcements
        Route::get('announcements', [AnnouncementsController::class, 'list'])->name('announcements.index');
        Route::get('announcements/create', [AnnouncementsController::class, 'create'])->name('announcements.create');
        Route::post('announcements/announce', [AnnouncementsController::class, 'announce'])->name('announcements.announce');
        // End - Announcements
    });

//
//    Route::get('blogs/{slug}', [PublicBlogsController::class, 'details'])->name('public.blogs.details');
//    Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs.index');
//
//    Route::get('pages/about', [PublicPagesController::class, 'about'])->name('public.pages.about');
    Route::get('/', [PublicHomeController::class, 'index'])->name('public.home');

});
