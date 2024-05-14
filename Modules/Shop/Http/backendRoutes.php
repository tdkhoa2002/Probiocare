<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/shop'], function (Router $router) {
    $router->bind('shop', function ($id) {
        return app('Modules\Shop\Repositories\ShopRepository')->find($id);
    });
    $router->get('shops', [
        'as' => 'admin.shop.shop.index',
        'uses' => 'ShopController@index',
        'middleware' => 'can:shop.shops.index'
    ]);
    $router->get('shops/create', [
        'as' => 'admin.shop.shop.create',
        'uses' => 'ShopController@create',
        'middleware' => 'can:shop.shops.create'
    ]);
    $router->post('shops', [
        'as' => 'admin.shop.shop.store',
        'uses' => 'ShopController@store',
        'middleware' => 'can:shop.shops.create'
    ]);
    $router->get('shops/{shop}/edit', [
        'as' => 'admin.shop.shop.edit',
        'uses' => 'ShopController@edit',
        'middleware' => 'can:shop.shops.edit'
    ]);
    $router->put('shops/{shop}', [
        'as' => 'admin.shop.shop.update',
        'uses' => 'ShopController@update',
        'middleware' => 'can:shop.shops.edit'
    ]);
    $router->delete('shops/{shop}', [
        'as' => 'admin.shop.shop.destroy',
        'uses' => 'ShopController@destroy',
        'middleware' => 'can:shop.shops.destroy'
    ]);
// append

});
