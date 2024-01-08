<?php

use Illuminate\Routing\Router;
/** @var Router $router */
$router->group(['prefix' =>'/cryperrswap'], function (Router $router) {
    $router->bind('service', function ($id) {
        return app('Modules\Cryperrswap\Repositories\ServiceRepository')->find($id);
    });
    $router->get('services', [
        'as' => 'admin.cryperrswap.service.index',
        'uses' => 'ServiceController@index',
        'middleware' => 'can:cryperrswap.services.index'
    ]);
    $router->get('services/create', [
        'as' => 'admin.cryperrswap.service.create',
        'uses' => 'ServiceController@create',
        'middleware' => 'can:cryperrswap.services.create'
    ]);
    $router->post('services', [
        'as' => 'admin.cryperrswap.service.store',
        'uses' => 'ServiceController@store',
        'middleware' => 'can:cryperrswap.services.create'
    ]);
    $router->get('services/{service}/edit', [
        'as' => 'admin.cryperrswap.service.edit',
        'uses' => 'ServiceController@edit',
        'middleware' => 'can:cryperrswap.services.edit'
    ]);
    $router->put('services/{service}', [
        'as' => 'admin.cryperrswap.service.update',
        'uses' => 'ServiceController@update',
        'middleware' => 'can:cryperrswap.services.edit'
    ]);
    $router->delete('services/{service}', [
        'as' => 'admin.cryperrswap.service.destroy',
        'uses' => 'ServiceController@destroy',
        'middleware' => 'can:cryperrswap.services.destroy'
    ]);
    $router->bind('currency', function ($id) {
        return app('Modules\Cryperrswap\Repositories\CurrencyRepository')->find($id);
    });
    $router->get('currencies', [
        'as' => 'admin.cryperrswap.currency.index',
        'uses' => 'CurrencyController@index',
        'middleware' => 'can:cryperrswap.currencies.index'
    ]);
    $router->get('currencies/create', [
        'as' => 'admin.cryperrswap.currency.create',
        'uses' => 'CurrencyController@create',
        'middleware' => 'can:cryperrswap.currencies.create'
    ]);
    $router->post('currencies', [
        'as' => 'admin.cryperrswap.currency.store',
        'uses' => 'CurrencyController@store',
        'middleware' => 'can:cryperrswap.currencies.create'
    ]);
    $router->get('currencies/{currency}/edit', [
        'as' => 'admin.cryperrswap.currency.edit',
        'uses' => 'CurrencyController@edit',
        'middleware' => 'can:cryperrswap.currencies.edit'
    ]);
    $router->put('currencies/{currency}', [
        'as' => 'admin.cryperrswap.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'can:cryperrswap.currencies.edit'
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'admin.cryperrswap.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'can:cryperrswap.currencies.destroy'
    ]);
    $router->bind('order', function ($id) {
        return app('Modules\Cryperrswap\Repositories\OrderRepository')->find($id);
    });
    $router->get('orders', [
        'as' => 'admin.cryperrswap.order.index',
        'uses' => 'OrderController@index',
        'middleware' => 'can:cryperrswap.orders.index'
    ]);
    $router->get('orders/create', [
        'as' => 'admin.cryperrswap.order.create',
        'uses' => 'OrderController@create',
        'middleware' => 'can:cryperrswap.orders.create'
    ]);
    $router->post('orders', [
        'as' => 'admin.cryperrswap.order.store',
        'uses' => 'OrderController@store',
        'middleware' => 'can:cryperrswap.orders.create'
    ]);
    $router->get('orders/{order}/edit', [
        'as' => 'admin.cryperrswap.order.edit',
        'uses' => 'OrderController@edit',
        'middleware' => 'can:cryperrswap.orders.edit'
    ]);
    $router->put('orders/{order}', [
        'as' => 'admin.cryperrswap.order.update',
        'uses' => 'OrderController@update',
        'middleware' => 'can:cryperrswap.orders.edit'
    ]);
    $router->delete('orders/{order}', [
        'as' => 'admin.cryperrswap.order.destroy',
        'uses' => 'OrderController@destroy',
        'middleware' => 'can:cryperrswap.orders.destroy'
    ]);
// append



});
