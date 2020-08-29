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
//
//Route::middleware('auth:api')->get('/setting', function (Request $request) {
//    return $request->user();
//});
Route::group(['middleware' => ['auth:api', 'check_permission:setting'], 'prefix' => 'v1/admin'], function () {
    Route::resource('setting', 'SettingController')->except(['create', 'edit']);
});
Route::group(['prefix' => 'v1'], function () {
    Route::get('setting_topic', "SettingFrontController@settingTopic");
    Route::get('setting', "SettingFrontController@setting");
});
