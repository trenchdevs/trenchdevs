<?php

use App\Http\Controllers\Api\ApiNotes;
use App\Http\Controllers\Api\ApiProductReactions;
use App\Http\Controllers\Api\ApiProductStories;
use App\Http\Controllers\Api\ApiStories;
use App\Http\Controllers\Api\ApiStoryResponses;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Blogs\PublicBlogsController;
use App\Http\Controllers\Shop\ProductsController;
use App\Models\Stories\ProductStory;
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
    Route::post('upsert', [ApiStories::class, 'upsert']);
    Route::get('metrics', [ApiStories::class, 'metrics']);
    Route::get('{storyId}', [ApiStories::class, 'one']);
    Route::get('/', [ApiStories::class, 'all']);

    Route::post('add-products', [ApiProductStories::class, 'addProductsToStories']);
});

Route::group(['prefix' => 'product-reactions'], function () {
    Route::post('react', [ApiProductReactions::class, 'react']);
});

Route::group(['prefix' => 'story-responses'], function () {
    Route::get('/', [ApiStoryResponses::class, 'all']);
    Route::post('add', [ApiStoryResponses::class, 'store']);
});

Route::get('stories/s/{slug}', [ApiStories::class, 'slug']);

// ---------- End Authentication Endpoints ---------- //

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
