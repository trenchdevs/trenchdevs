<?php

use App\Modules\TrenchDevs\Http\Controllers\PublicController;
use App\Public\Controllers\Blogs\PublicBlogsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs');
Route::get('/', [PublicController::class, 'index'])->name('public.home');

// start - public documents
Route::view('documents/privacy', 'documents.privacy')->name('documents.privacy');
Route::view('documents/tnc', 'documents.tnc')->name('documents.tnc');
// end - public documents

//Route::get('/', function () {
//    return $this->inertiaRender('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/dashboard', function () {
    return $this->inertiaRender('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/../auth.php';
