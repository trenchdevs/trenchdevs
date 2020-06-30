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

Route::get('test', function(){
    return response()->json([
        '@test'
    ]);
});

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');
Route::post('me', 'AuthController@me');

Route::get('product_categories/', 'ProductCategoryController@all');
Route::get('product_categories/parent_categories', 'ProductCategoryController@allParentCategories');
Route::post('product_categories/upsert', 'ProductCategoryController@upsert');

