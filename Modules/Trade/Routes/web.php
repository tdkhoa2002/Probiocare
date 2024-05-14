<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('trade')->group(function () {
    Route::get('/pairs', 'PublicController@getTradingPairsList')->name('fe.trade.trade.list');
    Route::get('/pair/{symbol}', 'PublicController@getTradingPair')->name('fe.trade.trade.pair');
});
Route::prefix('mm')->group(function () {
    Route::get('/price', 'PublicController@getFakePrice');
});

Route::prefix('api/trade')->group(function () {
    Route::get('/getListMarket', 'PublicApiController@getListMarket');
    Route::get('/my-trades/symbol/{symbol}', 'PublicApiController@getMyTrades');
});

Route::prefix('api/trade')->middleware('check-auth')->group(function () {
    Route::get('/getBalanceTrade/{symbol}', 'PublicApiController@getBalanceTrade');
    Route::get('/countTotalTrade', 'PublicApiController@countTotalTrade');
    Route::post('/handle', 'PublicApiController@trade');
    Route::post('/cancelTrade/{tradeId}', 'PublicApiController@cancelTrade');
});

Route::prefix('webhook')->group(function () {
    Route::post('/handleTrade', 'WebhookController@handleTrade')->name('wh.trade.trade.handleTrade');

    Route::get('/test-pusher', 'WebhookController@testPusher');

});
