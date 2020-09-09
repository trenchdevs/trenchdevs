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
        Route::get('/parent_categories', 'ProductCategoriesController@allParentCategories');
        Route::post('/upsert', 'ProductCategoriesController@upsert');
        Route::post('/delete/{categoryId}', 'ProductCategoriesController@delete');
        Route::post('/toggle_is_featured/{categoryId}', 'ProductCategoriesController@toggleIsFeatured');
    });

    Route::get('/', 'ProductCategoriesController@all');
    Route::get('/{categoryId}', 'ProductCategoriesController@one');
});

Route::group([
    'prefix' => 'products',
    'middleware' => 'validAccount'
], function () {

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/upsert', 'ProductsController@upsert');
        Route::post('/delete/{productId}', 'ProductsController@delete');
    });

    Route::get('/', 'ProductsController@all');
    Route::get('/{productId}', 'ProductsController@one');
});





