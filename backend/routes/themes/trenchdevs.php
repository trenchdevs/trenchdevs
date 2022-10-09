<?php

use App\Modules\Blogs\Http\Controllers\PublicBlogsController;
use App\Modules\Themes\TrenchDevs\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

require __DIR__  . '/../trenchdevs_dashboard.php';

Route::middleware('web')->group(function(){
    /**
     * Public Rendered Pages (Blade)
     */
    Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs');

    Route::get('/', [DashboardController::class, 'index'])->name('public.home');
    Route::get('{slug}', [DashboardController::class, 'show'])->name('public.show');
});
