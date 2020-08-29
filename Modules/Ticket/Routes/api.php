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

//Route::middleware('auth:api')->get('/ticket', function (Request $request) {
//    return $request->user();
//});
Route::group(['middleware' => ['auth:api','user_active'],'prefix' => 'v1/user/ticket'], function() {
 Route::post('create','TicketControllerApi@createTicket');
    Route::get('','TicketControllerApi@getAllTicketUser');
    Route::get('/{id}','TicketControllerApi@getTicktById');
});
Route::group(['middleware' => ['auth:api','check_permission:ticket'],'prefix' => 'v1/admin/ticket'], function() {
    Route::post('create_status', 'TicketAdminController@createTicketStatus');
    Route::get('status','TicketAdminController@getStatus');
    Route::get('get_status/{id}','TicketAdminController@ticketStatusId');
    Route::post('create','TicketAdminController@replyTicket');
    Route::get('','TicketAdminController@getAllTickets');
    Route::get('/{id}','TicketControllerApi@getTicktById');
});
