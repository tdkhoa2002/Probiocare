<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/shoppingcart'], function (Router $router) {

    $router->post('/addToCart', [
        'as' => 'fe.shoppingcart.addToCart',
        'uses' => 'PublicController@addToCart'
    ]);
    $router->post('/quickBuy', [
        'as' => 'fe.shoppingcart.quickBuy',
        'uses' => 'PublicController@quickBuy'
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
$checkAuth = config('asgard.shoppingcart.config.check_auth');
if ($checkAuth) {
    $router->get(trans('shoppingcart::shoppingcarts.router.carts'), [
        'as' => 'fe.shoppingcart.getCart',
        'uses' => 'PublicController@getCart'
    ])->middleware('check-auth');
    $router->get(trans('shoppingcart::shoppingcarts.router.checkout'), [
        'as' => 'fe.shoppingcart.getCheckout',
        'uses' => 'PublicController@getCheckout'
    ])->middleware('check-auth');
    $router->get(trans('shoppingcart::shoppingcarts.router.order-success') . '/{code}', [
        'as' => 'fe.shoppingcart.getThankYou',
        'uses' => 'PublicController@getThankYou'
    ])->middleware('check-auth');
} else {
    $router->get(trans('shoppingcart::shoppingcarts.router.carts'), [
        'as' => 'fe.shoppingcart.getCart',
        'uses' => 'PublicController@getCart'
    ]);
    $router->get(trans('shoppingcart::shoppingcarts.router.checkout'), [
        'as' => 'fe.shoppingcart.getCheckout',
        'uses' => 'PublicController@getCheckout'
    ]);
    $router->get(trans('shoppingcart::shoppingcarts.router.order-success') . '/{code}', [
        'as' => 'fe.shoppingcart.getThankYou',
        'uses' => 'PublicController@getThankYou'
    ]);
    $router->get(trans('shoppingcart::shoppingcarts.router.order-fail') . '/{code}', [
        'as' => 'fe.shoppingcart.getPaymentFail',
        'uses' => 'PublicController@getPaymentFail'
    ]);
}

$router->get('testAlepay', [
    'as' => 'fe.shoppingcart.testAlepay',
    'uses' => 'PublicController@testAlepay'
]);

$router->group(['prefix' => '/alepay'], function (Router $router) {

    $router->get('order-success/{code}', [
        'as' => 'fe.shoppingcart.alepayCheckoutSuccess',
        'uses' => 'PublicController@alepayCheckoutSuccess'
    ]);
    $router->get('order-fail/{code}', [
        'as' => 'fe.shoppingcart.alepayCheckoutFail',
        'uses' => 'PublicController@alepayCheckoutFail'
    ]);
});
