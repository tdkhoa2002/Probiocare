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
    $router->get('api/checkout', [
        'as' => 'api.fe.shoppingcart.getCartInfo',
        'uses' => 'PublicApiController@getCartInfo'
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
    $router->get('api/checkout', [
        'as' => 'api.fe.shoppingcart.getCartInfo',
        'uses' => 'PublicApiController@getCartInfo'
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

$router->group(['prefix' => '/paypal'], function (Router $router) {
    $router->get('create-transaction', [
        'as' => 'fe.shoppingcart.createTransaction',
        'uses' => 'PublicController@createTransaction'
    ]);
    $router->get('process-transaction', [
        'as' => 'fe.shoppingcart.processTransaction',
        'uses' => 'PublicController@processTransaction'
    ]);
    $router->get('success-transaction/{order_code}', [
        'as' => 'fe.shoppingcart.successTransaction',
        'uses' => 'PublicController@successTransaction'
    ]);
    $router->get('cancel-transaction', [
        'as' => 'fe.shoppingcart.cancelTransaction',
        'uses' => 'PublicController@cancelTransaction'
    ]);
});

$router->group(['prefix' => '/web3'], function (Router $router) {
    $router->get('connect-wallet', [
        'as' => 'fe.shoppingcart.connectWallet',
        'uses' => 'PublicController@connectWallet'
    ]);
    $router->post('buy-product', [
        'as' => 'fe.shoppingcart.buyProductWeb3',
        'uses' => 'PublicController@buyProductWeb3'
    ]);
});