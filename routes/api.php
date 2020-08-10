<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    return response()->json([
        '@test'
    ]);
});

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::post('me', 'AuthController@me');

Route::group([
    'prefix' => 'product_categories',
    'middleware' => 'validAccount'
], function () {

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/parent_categories', 'ProductCategoryController@allParentCategories');
        Route::post('/upsert', 'ProductCategoryController@upsert');
        Route::post('/delete/{categoryId}', 'ProductCategoryController@delete');
        Route::post('/toggle_is_featured/{categoryId}', 'ProductCategoryController@toggleIsFeatured');
    });

    Route::get('/', 'ProductCategoryController@all');
    Route::get('/{categoryId}', 'ProductCategoryController@one');
});

Route::group([
    'prefix' => 'products',
    'middleware' => 'validAccount'
], function () {

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/upsert', 'ProductController@upsert');
        Route::post('/delete/{productId}', 'ProductController@delete');
    });

    Route::get('/', 'ProductController@all');
    Route::get('/{productId}', 'ProductController@one');
});





