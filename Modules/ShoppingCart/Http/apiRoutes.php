<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/shoppingcart', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('orders', [
        'as' => 'api.shoppingcart.order.indexServerSide',
        'uses' => 'OrderController@indexServerSide',
        'middleware' => 'can:shoppingcart.orders.index'
    ]);
    $router->get('getStatusOrder', [
        'as' => 'api.shoppingcart.order.getStatusOrder',
        'uses' => 'OrderController@getStatusOrder',
        'middleware' => 'can:shoppingcart.orders.index'
    ]);
    $router->get('orders/find', [
        'as' => 'api.shoppingcart.order.find',
        'uses' => 'OrderController@find',
        'middleware' => 'can:shoppingcart.orders.index'
    ]);
    $router->post('orders/{orderId}/update', [
        'as' => 'api.shoppingcart.order.update',
        'uses' => 'OrderController@update',
        'middleware' => 'can:shoppingcart.orders.edit'
    ]);
    $router->delete('orders/{orderId}/destroy', [
        'as' => 'api.shoppingcart.order.destroy',
        'uses' => 'OrderController@destroy',
        'middleware' => 'can:shoppingcart.orders.destroy'
    ]);
});
