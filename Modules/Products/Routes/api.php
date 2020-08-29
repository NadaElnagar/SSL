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
Route::group(['prefix'=>'v1/product'], function() {

    Route::get('by_category_id', 'ProductsControllerApi@getProductByCategoryID');
    Route::get('by_brand_id', 'ProductsControllerApi@getProductByBrandID');
    Route::get('/', 'ProductsControllerApi@allAprovedProduct');
    Route::get('/{id}', 'ProductsControllerApi@getProductById');

});
Route::group(['middleware' => ['auth:api','check_permission:order'],'prefix' => 'v1/admin/product'], function() {
    Route::get('approved','ProductsAdminController@approved');
    Route::get('un_approved','ProductsAdminController@unApproved');
    Route::put('update_status/{id}','ProductsAdminController@updateProductStatus');
    Route::put('add_price/{id}','ProductsAdminController@addNewPriceFromAdmin');
    Route::get('price/{id}','ProductsAdminController@getProductPrice');
    Route::get('list_product','ProductsAdminController@listAllProduct');
});
