<?php
use Illuminate\Routing\Router;

$router->group(['prefix' => '/shop', 'middleware' => 'check-auth'], function (Router $router) {
    $router->get('/create', [
        'as' => 'fe.shop.shop.create',
        'uses' => 'ShopController@create'
    ]);
    $router->get('/information', [
        'as' => 'fe.shop.shop.info',
        'uses' => 'ShopController@show'
    ]);

    $router->post('/register', [
        'as' => 'fe.shop.shop.register',
        'uses' => 'ShopController@store'
    ]);

    $router->get('/create-product', [
        'as' => 'fe.shop.shop.create-product',
        'uses' => 'ShopController@createProduct'
    ]);

    $router->post('/store-product', [
        'as' => 'fe.shop.shop.store-product',
        'uses' => 'ShopController@storeProduct'
    ]);
});
