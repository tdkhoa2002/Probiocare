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

// Route::middleware('auth:api')->get('/peertopeer', function (Request $request) {
//     return $request->user();
// });

Route::prefix('p2p')->group(function() {
    Route::get('/get-ads', 'P2PController@getAds');

    Route::get('/get-orders/{customerID}', 'P2PController@getMyOrders')->name('fe.p2p.order.my.get');

});