<?php

use Illuminate\Http\Request;

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
Route::group(['prefix'=>'v1/cart','middleware'=>'auth:api','user_active'], function() {
    Route::post('', 'CartControllerApi@addToCart');
    Route::get('/', 'CartControllerApi@userCart');
    Route::get('/count', 'CartControllerApi@userCartCount');
    Route::get('/calculation', 'CartControllerApi@Calculation');
});
