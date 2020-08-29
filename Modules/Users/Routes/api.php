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
Route::group(['prefix'=>'v1/user'], function() {

    Route::post('login', 'UsersControllerApi@login');
    Route::post('register', 'UsersControllerApi@register');
    Route::group(['middleware' => 'auth:api','user_active'], function () {
        Route::get('/', 'UsersControllerApi@getUserDetails');
        Route::put('', 'UsersControllerApi@update');
        Route::put('update_password', 'UsersControllerApi@updatePassword');
        Route::post('logout', 'UsersControllerApi@logout');
    });
});
Route::group([ 'prefix' => 'v1/password'], function () {
    Route::post('create', 'PasswordResetControllerApi@sendPasswordResetToken');
    Route::post('reset', 'PasswordResetControllerApi@resetPassword');
});

Route::group(['middleware' => ['auth:api','check_permission:order'],'prefix' => 'v1/admin/user'], function() {
    Route::get('list_user', 'UsersControllerApi@listUser');
});
Route::group(['middleware' => ['auth:api','check_permission:admin'],'prefix' => 'v1/admin'], function() {
    Route::put('active_user', 'AdminControllerUsers@activeUser');
});
Route::group(['middleware' => ['auth:api'],'prefix' => 'v1/admin'], function() {
    Route::put('update_info', 'UsersControllerApi@update');
    Route::put('update_password', 'UsersControllerApi@updatePassword');
 });
