<?php

use Illuminate\Routing\Router;
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

Route::prefix('trading-data')->group(function () {
    Route::get('/get-order-data/{symbol}/{type}', 'TradingDataController@getOrderData');
    Route::get('/markets', 'TradingDataController@getMarkets');
    Route::get('/market-trades/{symbol}', 'TradingDataController@getMarketTrades')->name('pl.trade.tradingData.market');
    Route::get('/pair-info/{symbol}', 'TradingDataController@getPairInfo');
    Route::get('/chart/candle', 'TradingDataController@chartRequest');
});

// $router->get('/targetprices/getBotTrade', [
//     'as' => 'api.trade.targetprice.getBotTrade',
//     'uses' => 'ApiTargetPriceController@getSettingCustomerBot'
// ]);

$router->group(['prefix' => '/trade', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('markets-all', [
        'as' => 'api.trade.market.all',
        'uses' => 'MarketController@all',
        'middleware' => 'token-can:trade.markets.index',
    ]);
    $router->get('markets', [
        'as' => 'api.trade.market.indexServerSide',
        'uses' => 'MarketController@indexServerSide',
        'middleware' => 'token-can:trade.markets.index',
    ]);
    $router->get('markets/{marketId}', [
        'as' => 'api.trade.market.find',
        'uses' => 'MarketController@find',
        'middleware' => 'token-can:trade.markets.index',
    ]);
    $router->get('reSyncService/{marketId}', [
        'as' => 'api.trade.market.reSyncService',
        'uses' => 'MarketController@reSyncService',
        'middleware' => 'token-can:trade.markets.index',
    ]);

    $router->post('markets', [
        'as' => 'api.trade.market.store',
        'uses' => 'MarketController@store',
        'middleware' => 'token-can:trade.markets.create',
    ]);
    $router->post('markets/{market}', [
        'as' => 'api.trade.market.update',
        'uses' => 'MarketController@update',
        'middleware' => 'token-can:trade.markets.edit',
    ]);
    $router->delete('markets/{market}', [
        'as' => 'api.trade.market.destroy',
        'uses' => 'MarketController@destroy',
        'middleware' => 'token-can:trade.markets.destroy',
    ]);

    $router->get('trades', [
        'as' => 'api.trade.trade.indexServerSide',
        'uses' => 'TradeController@indexServerSide',
        'middleware' => 'token-can:trade.trades.index',
    ]);
    $router->post('trades/{tradeId}/cancel', [
        'as' => 'api.trade.trade.cancelTrade',
        'uses' => 'TradeController@cancelTrade',
        'middleware' => 'token-can:trade.trades.cancelTrade',
    ]);
});

$router->group(['prefix' => '/trade-api'], function (Router $router) {
    $router->get('balance', [
        'as' => 'api.customer.api-trade.balance',
        'uses' => 'TradeApiController@getBalance',
        'middleware' => 'api-key'
    ]);
    $router->get('ticker', [
        'as' => 'api.customer.api-trade.ticker',
        'uses' => 'TradeApiController@getTicker'
    ]);
    $router->get('order/my', [
        'as' => 'api.customer.api-trade.orders',
        'uses' => 'TradeApiController@listOrders',
        'middleware' => 'api-key'
    ]);
    $router->post('order/cancel', [
        'as' => 'api.customer.api-trade.cancelOrder', 
        'uses' => 'TradeApiController@cancelOrder',
        'middleware' => 'api-key'
    ]);
    $router->post('order/create', [
        'as' => 'api.customer.api-trade.createOrder',
        'uses' => 'TradeApiController@createOrder',
        'middleware' => 'api-key'
    ]);
});
