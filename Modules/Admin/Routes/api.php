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

//Route::middleware('auth:api')->get('/admin', function (Request $request) {
//    return $request->user();
//});
Route::post('v1/admin/login','LoginController@login');
Route::group(['middleware' => ['auth:api','check_permission:role'],'prefix' => 'v1/admin'], function() {
    Route::resource('roles', 'RoleController');
    Route::get('list_permission','RoleController@listPermission');
    Route::get('list_role','RoleController@getAllRoleRelatdPermission');
});
Route::group(['middleware' => ['auth:api','check_permission:admin'],'prefix' => 'v1/admin'], function() {
    Route::resource('admin', 'AdminControllerApi');
});
