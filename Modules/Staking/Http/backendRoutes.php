<?php

use Illuminate\Routing\Router;
/** @var Router $router */


$router->group(['prefix' =>'/staking'], function (Router $router) {
    $router->bind('package', function ($id) {
        return app('Modules\Staking\Repositories\PackageRepository')->find($id);
    });
    $router->get('packages', [
        'as' => 'admin.staking.package.index',
        'uses' => 'PackageController@index',
        'middleware' => 'can:staking.packages.index'
    ]);
    $router->get('packages/create', [
        'as' => 'admin.staking.package.create',
        'uses' => 'PackageController@create',
        'middleware' => 'can:staking.packages.create'
    ]);
    $router->post('packages', [
        'as' => 'admin.staking.package.store',
        'uses' => 'PackageController@store',
        'middleware' => 'can:staking.packages.create'
    ]);
    $router->get('packages/{package}/edit', [
        'as' => 'admin.staking.package.edit',
        'uses' => 'PackageController@edit',
        'middleware' => 'can:staking.packages.edit'
    ]);
    $router->put('packages/{package}', [
        'as' => 'admin.staking.package.update',
        'uses' => 'PackageController@update',
        'middleware' => 'can:staking.packages.edit'
    ]);
    $router->delete('packages/{package}', [
        'as' => 'admin.staking.package.destroy',
        'uses' => 'PackageController@destroy',
        'middleware' => 'can:staking.packages.destroy'
    ]);
    $router->bind('order', function ($id) {
        return app('Modules\Staking\Repositories\OrderRepository')->find($id);
    });
    $router->get('orders', [
        'as' => 'admin.staking.order.index',
        'uses' => 'OrderController@index',
        'middleware' => 'can:staking.orders.index'
    ]);
    $router->get('orders/{order}/detail', [
        'as' => 'admin.staking.order.detail',
        'uses' => 'OrderController@detail',
        'middleware' => 'can:staking.orders.detail'
    ]);
// append





});
