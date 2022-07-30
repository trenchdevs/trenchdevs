<?php

// START - users
use App\Modules\Users\Http\Controllers\PortfolioController;
use App\Modules\Users\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('admin/users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('admin/users/upsert', [UsersController::class, 'upsert'])->name('users.upsert');
Route::post('admin/users/password_reset', [UsersController::class, 'passwordReset'])->name('users.password_reset');
Route::get('admin/users/{id}', [UsersController::class, 'edit'])->name('users.edit');
Route::get('admin/users', [UsersController::class, 'index'])->name('users.index');

// change password
Route::get('portfolio/security', [PortfolioController::class, 'showSecurity'])->name('portfolio.security');
Route::post('users/change_password', [UsersController::class, 'changePassword'])->name('users.change_password');
// End - users
