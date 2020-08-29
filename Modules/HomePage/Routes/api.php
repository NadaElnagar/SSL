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

Route::middleware('auth:api')->get('/homepage', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api','check_permission:home_page'],'prefix' => 'v1/admin'], function() {
    Route::resource('slider', 'HPAdmin')->except(['create', 'edit']);
    Route::resource('hp_collection', 'HPCollectionController')->except(['create', 'edit']);
});
Route::group(['prefix'=>'v1/user'], function() {
    Route::get('slider','HPAdmin@getSliderFront');
    Route::get('collection','HPCollectionFrontController@frontListCollection');

});
