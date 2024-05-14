<?php

use Illuminate\Routing\Router;
/** @var Router $router */


$router->group(['prefix' =>'/loyalty'], function (Router $router) {
    $router->bind('packageLoyalty', function ($id) {
        return app('Modules\Loyalty\Repositories\PackageRepository')->find($id);
    });
    $router->get('packages', [
        'as' => 'admin.loyalty.package.index',
        'uses' => 'PackageController@index',
        'middleware' => 'can:loyalty.packages.index'
    ]);
    $router->get('packages/create', [
        'as' => 'admin.loyalty.package.create',
        'uses' => 'PackageController@create',
        'middleware' => 'can:loyalty.packages.create'
    ]);
    $router->post('packages', [
        'as' => 'admin.loyalty.package.store',
        'uses' => 'PackageController@store',
        'middleware' => 'can:loyalty.packages.create'
    ]);
    $router->get('packages/{packageLoyalty}/edit', [
        'as' => 'admin.loyalty.package.edit',
        'uses' => 'PackageController@edit',
        'middleware' => 'can:loyalty.packages.edit'
    ]);
    $router->put('packages/{packageLoyalty}', [
        'as' => 'admin.loyalty.package.update',
        'uses' => 'PackageController@update',
        'middleware' => 'can:loyalty.packages.edit'
    ]);
    $router->delete('packages/{packageLoyalty}', [
        'as' => 'admin.loyalty.package.destroy',
        'uses' => 'PackageController@destroy',
        'middleware' => 'can:loyalty.packages.destroy'
    ]);
    $router->bind('orderLoyalty', function ($id) {
        return app('Modules\Loyalty\Repositories\OrderRepository')->find($id);
    });
    $router->get('orders', [
        'as' => 'admin.loyalty.order.index',
        'uses' => 'OrderController@index',
        'middleware' => 'can:loyalty.orders.index'
    ]);
    $router->get('orders/create', [
        'as' => 'admin.loyalty.order.create',
        'uses' => 'OrderController@create',
        'middleware' => 'can:loyalty.orders.create'
    ]);
    $router->post('orders', [
        'as' => 'admin.loyalty.order.store',
        'uses' => 'OrderController@store',
        'middleware' => 'can:loyalty.orders.create'
    ]);
    $router->get('orders/{orderLoyalty}/edit', [
        'as' => 'admin.loyalty.order.edit',
        'uses' => 'OrderController@edit',
        'middleware' => 'can:loyalty.orders.edit'
    ]);
    $router->put('orders/{orderLoyalty}', [
        'as' => 'admin.loyalty.order.update',
        'uses' => 'OrderController@update',
        'middleware' => 'can:loyalty.orders.edit'
    ]);
    $router->delete('orders/{orderLoyalty}', [
        'as' => 'admin.loyalty.order.destroy',
        'uses' => 'OrderController@destroy',
        'middleware' => 'can:loyalty.orders.destroy'
    ]);
// append






});
