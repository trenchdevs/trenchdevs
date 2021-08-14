<?php

/*
|--------------------------------------------------------------------------
| Web API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register webapi routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "web" and "webapi" middleware group. Enjoy building your API!
|  Perfect for SPAs like React using Sessions for authentication
| eg. trenchdevs.org/webapi/*
|
*/


use App\Domains\Users\Http\Controllers\WebApi\UsersController;
use App\Http\Controllers\WebApiController;
use Illuminate\Support\Facades\Route;


Route::get('hello', function () {
    return response()->json(['hellao']);
});
Route::middleware(['auth:web'])->group(function () {
    Route::get('init', [WebApiController::class, 'init']);
    Route::post('users/all', [UsersController::class, 'getUsers']);
});


// Route::get('blogs', [BlogsController::class, 'index']);




