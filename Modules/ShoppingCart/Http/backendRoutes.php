<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/shoppingcart'], function (Router $router) {
    $router->bind('shoppingcartOrder', function ($id) {
        return app('Modules\ShoppingCart\Repositories\OrderRepository')->find($id);
    });
    $router->get('orders', [
        'as' => 'admin.shoppingcart.order.index',
        'uses' => 'OrderController@index',
        'middleware' => 'can:shoppingcart.orders.index'
    ]);
    $router->get('orders/{shoppingcartOrder}/edit', [
        'as' => 'admin.shoppingcart.order.edit',
        'uses' => 'OrderController@edit',
        'middleware' => 'can:shoppingcart.orders.edit'
    ]);
    $router->put('orders/{shoppingcartOrder}', [
        'as' => 'admin.shoppingcart.order.update',
        'uses' => 'OrderController@update',
        'middleware' => 'can:shoppingcart.orders.edit'
    ]);
    $router->delete('orders/{shoppingcartOrder}', [
        'as' => 'admin.shoppingcart.order.destroy',
        'uses' => 'OrderController@destroy',
        'middleware' => 'can:shoppingcart.orders.destroy'
    ]);
    
// append


});
