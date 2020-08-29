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
Route::group(['prefix' => 'v1/ssl'], function () {
    Route::post('/', 'SSLControllerApi@fetchDataSSL');
});
Route::group(['prefix'=>'v1/ssl','middleware'=>'auth:api','user_active'], function() {
    Route::get('/invite_order','SSLControllerApi@inviteOrder');

});
