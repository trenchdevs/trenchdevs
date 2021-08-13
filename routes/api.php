<?php

use App\Domains\Activities\Http\Controllers\ActivitiesController;
use App\Domains\Stories\Http\Controllers\ApiNotes;
use App\Domains\Stories\Http\Controllers\ProductReactionsController;
use App\Domains\Stories\Http\Controllers\ProductStoriesController;
use App\Domains\Stories\Http\Controllers\Stories;
use App\Domains\Stories\Http\Controllers\StoryResponsesController;
use App\Http\Controllers\AuthController;
use App\Domains\Blogs\Http\Controllers\PublicBlogsController;
use App\Domains\Products\Http\Controllers\ProductsController;
use App\Domains\Stories\Models\ProductStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// ---------- Start Authentication Endpoints ---------- //
Route::group(['prefix' => 'auth'], function () {

    Route::post('register', [AuthController::class, 'register'])->name('api.register');
    Route::post('login', [AuthController::class, 'login'])->name('api.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::post('me', [AuthController::class, 'me'])->name('api.me');
    Route::post('sud', [AuthController::class, 'sud']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('refresh', [AuthController::class, 'refreshToken'])->name('api.refresh');
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {

    // ---------- Start Notes ---------- //
    Route::post('notes', [ApiNotes::class, 'index']);
    Route::post('notes/upsert', [ApiNotes::class, 'upsert']);

    // ---------- End Notes ---------- //

});


Route::group(['prefix' => 'shop/products', 'middleware' => 'auth:sanctum'], function () {
    Route::post('upsert', [ProductsController::class, 'upsert']);
    Route::get('{productId}', [ProductsController::class, 'one']);
    Route::get('/', [ProductsController::class, 'all']);
});

Route::group(['prefix' => 'stories', 'middleware' => 'auth:sanctum'], function () {
    Route::post('upsert', [Stories::class, 'upsert']);
    Route::get('metrics', [Stories::class, 'metrics']);
    Route::get('{storyId}', [Stories::class, 'one']);
    Route::get('/', [Stories::class, 'all']);

    Route::post('add-products', [ProductStoriesController::class, 'addProductsToStories']);
});

Route::group(['prefix' => 'product-reactions'], function () {
    Route::post('react', [ProductReactionsController::class, 'react']);
});

Route::group(['prefix' => 'story-responses'], function () {
    Route::get('/', [StoryResponsesController::class, 'all']);
    Route::post('add', [StoryResponsesController::class, 'store']);
});

Route::get('stories/s/{slug}', [Stories::class, 'slug']);

// ---------- End Authentication Endpoints ---------- //

Route::post('activities', [ActivitiesController::class, 'store'])->middleware(['ip-restricted']);

// commented out for now 20210304
//
//Route::group(['prefix' => 'shop', 'middleware' => 'check.account'], function () {
//
//    // ---------- PRODUCTS ---------- //
//    Route::group(['prefix' => 'products'], function () {
//
//        Route::group(['middleware' => 'auth:api'], function () {
//            Route::post('upsert', 'ProductsController@upsert');
//            Route::post('delete/{productId}', 'ProductsController@delete');
//        });
//
//        Route::get('/', 'ProductsController@all');
//        Route::get('{productId}', 'ProductsController@one');
//    });
//
//    // ---------- PRODUCTS CATEGORIES ---------- //
//    Route::group(['prefix' => 'product_categories'], function () {
//        Route::group(['middleware' => 'auth:api'], function () {
//            Route::get('parent_categories', 'ProductCategoriesController@allParentCategories');
//            Route::post('upsert', 'ProductCategoriesController@upsert');
//            Route::post('delete/{categoryId}', 'ProductCategoriesController@delete');
//            Route::post('toggle_is_featured/{categoryId}', 'ProductCategoriesController@toggleIsFeatured');
//        });
//
//        Route::get('/', 'ProductCategoriesController@all');
//        Route::get('/{categoryId}', 'ProductCategoriesController@one');
//    });
//
//});
