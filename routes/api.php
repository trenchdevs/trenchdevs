<?php

use App\Http\Controllers\Blogs\PublicBlogsController;
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

// ---------- Authentication Endpoints ---------- //
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('me', 'AuthController@me');
    // todo: add refresh token
});


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
