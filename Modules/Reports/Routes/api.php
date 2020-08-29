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

Route::middleware('auth:api')->get('/reports', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api', 'check_permission:reports'], 'prefix' => 'v1/admin/reports'], function () {
    Route::get('/dashboard', 'ReportsApiController@dashboard');
    Route::get('/dashboard_pdf', 'ReportsApiController@dashboardPdf');
    Route::get('/customer', 'ReportsApiController@customer');
    Route::get('/customer_pdf', 'ReportsApiController@customerPdf');
    Route::get('/cart', 'ReportsApiController@cart');
    Route::get('/cart_pdf', 'ReportsApiController@cartPdf');
    Route::get('/orders', 'ReportsApiController@orders');
    Route::get('/orders_pdf', 'ReportsApiController@ordersPdf');
    Route::get('/certificate', 'ReportsApiController@certificate');
    Route::get('/certificate_pdf', 'ReportsApiController@certificatePdf');

});
