<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/cryperrswap', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    
    $router->get('services', [
        'as' => 'api.cryperrswap.service.indexServerSide',
        'uses' => 'ServiceController@indexServerSide',
        'middleware' => 'token-can:cryperrswap.services.index',
    ]);
    $router->get('services-all', [
        'as' => 'api.cryperrswap.service.all',
        'uses' => 'ServiceController@all',
    ]);
    $router->get('services/{serviceId}', [
        'as' => 'api.cryperrswap.service.find',
        'uses' => 'ServiceController@find',
        'middleware' => 'token-can:cryperrswap.services.index',
    ]);

    $router->post('services', [
        'as' => 'api.cryperrswap.service.store',
        'uses' => 'ServiceController@store',
        'middleware' => 'token-can:cryperrswap.services.create',
    ]);
    $router->post('services/{service}', [
        'as' => 'api.cryperrswap.service.update',
        'uses' => 'ServiceController@update',
        'middleware' => 'token-can:cryperrswap.services.edit',
    ]);
    $router->delete('services/{service}', [
        'as' => 'api.cryperrswap.service.destroy',
        'uses' => 'ServiceController@destroy',
        'middleware' => 'token-can:cryperrswap.services.destroy',
    ]);
    $router->get('syncAddress/{service}', [
        'as' => 'api.cryperrswap.service.syncAddress',
        'uses' => 'ServiceController@syncAddress',
        'middleware' => 'token-can:cryperrswap.services.index',
    ]);

    $router->get('currencies', [
        'as' => 'api.cryperrswap.currency.indexServerSide',
        'uses' => 'CurrencyController@indexServerSide',
        'middleware' => 'token-can:cryperrswap.currencies.index',
    ]);
    $router->get('currencies/{currencyId}', [
        'as' => 'api.cryperrswap.currency.find',
        'uses' => 'CurrencyController@find',
        'middleware' => 'token-can:cryperrswap.currencies.index',
    ]);

    $router->post('currencies', [
        'as' => 'api.cryperrswap.currency.store',
        'uses' => 'CurrencyController@store',
        'middleware' => 'token-can:cryperrswap.currencies.create',
    ]);
    $router->post('currencies/{currency}', [
        'as' => 'api.cryperrswap.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'token-can:cryperrswap.currencies.edit',
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'api.cryperrswap.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'token-can:cryperrswap.currencies.destroy',
    ]);
});