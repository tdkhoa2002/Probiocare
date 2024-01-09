<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/shoppingcart', 'middleware' => 'api'], function (Router $router) {
    $router->post('add-to-cart', [
        'as' => 'fe.shoppingcart.addToCart',
        'uses' => 'PublicController@addToCart'
    ]);
    $router->post('deleteItem', [
        'as' => 'fe.shoppingcart.deleteItem',
        'uses' => 'PublicController@deleteItem'
    ]);
    $router->post('loadCart', [
        'as' => 'fe.shoppingcart.loadCart',
        'uses' => 'PublicController@loadCart'
    ]);
    $router->post('updateQty', [
        'as' => 'fe.shoppingcart.updateQty',
        'uses' => 'PublicController@updateQty'
    ]);
    $router->post('checkout', [
        'as' => 'fe.shoppingcart.checkout',
        'uses' => 'PublicController@checkout'
    ]);
});
$router->get('gio-hang', [
    'as' => 'fe.shoppingcart.getCart',
    'uses' => 'PublicController@getCart'
]);
$router->get('thanh-toan', [
    'as' => 'fe.shoppingcart.getCheckout',
    'uses' => 'PublicController@getCheckout'
]);
$router->get('thank-you/{code}', [
    'as' => 'fe.shoppingcart.getThankYou',
    'uses' => 'PublicController@getThankYou'
]);
$router->get('chi-tiet-don-hang/{code}', [
    'as' => 'fe.shoppingcart.getDetailCart',
    'uses' => 'PublicController@getDetailCart'
]);
