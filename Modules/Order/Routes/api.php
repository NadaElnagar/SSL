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
Route::group(['prefix'=>'v1/orders','middleware'=>'auth:api','user_active'], function() {
    Route::get('/', 'OrderControllerApi@getOrderHistory');
    Route::get('order/{id}', 'OrderControllerApi@orderDetails');
    Route::get('subscribe', 'OrderControllerApi@orderTransactionDetails');
    Route::post('auto_renew', 'OrderControllerApi@orderAutoRenew');
    Route::get('user_transaction', 'OrderControllerApi@userTransaction');
});

Route::group(['middleware' => ['auth:api','check_permission:order'],'prefix' => 'v1/admin/order'], function() {
    Route::get('list_order', 'OrderControllerApi@listOrder');
    Route::get('user_order/{id}', 'OrderControllerApi@getOrdersByUserID');

    Route::get('get_main_order/{id}', 'OrderControllerApi@getOrderHistoryByUserID');
    Route::get('order_details/{id}', 'OrderControllerApi@orderDetails');
});
