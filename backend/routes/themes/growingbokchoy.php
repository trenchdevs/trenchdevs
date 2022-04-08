<?php

use App\Domains\Blogs\Http\Controllers\BlogsController;
use App\Domains\TrenchDevs\Http\Controllers\HomeController;
use App\Domains\Users\Http\Controllers\UsersController;
use App\Public\Controllers\Blogs\PublicBlogsController;
use App\Public\Controllers\Pages\PublicPagesController;
use App\Public\Controllers\PublicHomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['ip-restricted'])->group(function(){
    Auth::routes(['verify' => true, 'register' => true]);

// start - blogs - public
//Route::get('b/{id}', [PublicBlogsController::class, 'show'])->name('blogs.show');
// end - blogs -public

    Route::middleware(['auth:web', 'verified'])->prefix('portal')->group(function () {
        Route::get('home', [HomeController::class, 'index'])->name('portal.home');

        // start - blogs
        Route::get('blogs', [BlogsController::class, 'index'])->name('blogs.index');
        Route::get('blogs/upsert/{blogId?}', [BlogsController::class, 'upsert'])->name('blogs.upsert');
        Route::post('blogs/store', [BlogsController::class, 'store'])->name('blogs.store');
        Route::get('blogs/show/{id}', [BlogsController::class, 'show'])->name('blogs.show');
        Route::post('blogs/moderate/{id}', [BlogsController::class, 'moderate'])->name('blogs.moderate');

        // START - users
        Route::get('admin/users/create', [UsersController::class, 'create'])->name('users.create');
        Route::post('admin/users/upsert', [UsersController::class, 'upsert'])->name('users.upsert');
        Route::post('admin/users/password_reset', [UsersController::class, 'passwordReset'])->name('users.password_reset');
        Route::get('admin/users/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::get('admin/users', [UsersController::class, 'index'])->name('users.index');
        Route::post('users/change_password', [UsersController::class, 'changePassword'])->name('users.change_password');
        // End - users
    });


    Route::get('blogs/{slug}', [PublicBlogsController::class, 'details'])->name('public.blogs.details');
    Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs.index');

    Route::get('pages/about', [PublicPagesController::class, 'about'])->name('public.pages.about');
    Route::get('/', [PublicHomeController::class, 'index'])->name('public.home');

});