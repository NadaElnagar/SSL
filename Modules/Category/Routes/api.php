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
Route::group(['middleware' => ['auth:api'],'prefix' => 'v1/admin'], function() {
    Route::resource('category', 'CategoryControllerAdmin')->except(['create', 'edit','store','destroy']);
    Route::get('brand','BrandControllerAdmin@index');
});
Route::group(['prefix'=>'v1/user'], function() {
    Route::get('brand','BrandControllerAdmin@index');
    Route::get('category','CategoryControllerAdmin@index');

});
