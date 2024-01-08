<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/trade'], function (Router $router) {
    $router->bind('martker', function ($id) {
        return app('Modules\Trade\Repositories\MarketRepository')->find($id);
    });
    $router->get('markets', [
        'as' => 'admin.trade.market.index',
        'uses' => 'MarketController@index',
        'middleware' => 'can:trade.markets.index'
    ]);
    $router->get('markets/create', [
        'as' => 'admin.trade.market.create',
        'uses' => 'MarketController@create',
        'middleware' => 'can:trade.markets.create'
    ]);
    $router->post('markets', [
        'as' => 'admin.trade.market.store',
        'uses' => 'MarketController@store',
        'middleware' => 'can:trade.markets.create'
    ]);
    $router->get('markets/{martker}/edit', [
        'as' => 'admin.trade.market.edit',
        'uses' => 'MarketController@edit',
        'middleware' => 'can:trade.markets.edit'
    ]);
    $router->put('markets/{martker}', [
        'as' => 'admin.trade.market.update',
        'uses' => 'MarketController@update',
        'middleware' => 'can:trade.markets.edit'
    ]);
    $router->delete('markets/{martker}', [
        'as' => 'admin.trade.market.destroy',
        'uses' => 'MarketController@destroy',
        'middleware' => 'can:trade.markets.destroy'
    ]);
    $router->bind('trade', function ($id) {
        return app('Modules\Trade\Repositories\TradeRepository')->find($id);
    });
    $router->get('trades', [
        'as' => 'admin.trade.trade.index',
        'uses' => 'TradeController@index',
        'middleware' => 'can:trade.trades.index'
    ]);
    $router->get('trades/create', [
        'as' => 'admin.trade.trade.create',
        'uses' => 'TradeController@create',
        'middleware' => 'can:trade.trades.create'
    ]);
    $router->post('trades', [
        'as' => 'admin.trade.trade.store',
        'uses' => 'TradeController@store',
        'middleware' => 'can:trade.trades.create'
    ]);
    $router->get('trades/{trade}/edit', [
        'as' => 'admin.trade.trade.edit',
        'uses' => 'TradeController@edit',
        'middleware' => 'can:trade.trades.edit'
    ]);
    $router->put('trades/{trade}', [
        'as' => 'admin.trade.trade.update',
        'uses' => 'TradeController@update',
        'middleware' => 'can:trade.trades.edit'
    ]);
    $router->delete('trades/{trade}', [
        'as' => 'admin.trade.trade.destroy',
        'uses' => 'TradeController@destroy',
        'middleware' => 'can:trade.trades.destroy'
    ]);
    $router->bind('tradehistory', function ($id) {
        return app('Modules\Trade\Repositories\TradeHistoryRepository')->find($id);
    });
    $router->get('tradehistories', [
        'as' => 'admin.trade.tradehistory.index',
        'uses' => 'TradeHistoryController@index',
        'middleware' => 'can:trade.tradehistories.index'
    ]);
    $router->get('tradehistories/create', [
        'as' => 'admin.trade.tradehistory.create',
        'uses' => 'TradeHistoryController@create',
        'middleware' => 'can:trade.tradehistories.create'
    ]);
    $router->post('tradehistories', [
        'as' => 'admin.trade.tradehistory.store',
        'uses' => 'TradeHistoryController@store',
        'middleware' => 'can:trade.tradehistories.create'
    ]);
    $router->get('tradehistories/{tradehistory}/edit', [
        'as' => 'admin.trade.tradehistory.edit',
        'uses' => 'TradeHistoryController@edit',
        'middleware' => 'can:trade.tradehistories.edit'
    ]);
    $router->put('tradehistories/{tradehistory}', [
        'as' => 'admin.trade.tradehistory.update',
        'uses' => 'TradeHistoryController@update',
        'middleware' => 'can:trade.tradehistories.edit'
    ]);
    $router->delete('tradehistories/{tradehistory}', [
        'as' => 'admin.trade.tradehistory.destroy',
        'uses' => 'TradeHistoryController@destroy',
        'middleware' => 'can:trade.tradehistories.destroy'
    ]);
// append





});
