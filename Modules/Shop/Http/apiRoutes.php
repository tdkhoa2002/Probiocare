<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/shop', 'middleware' => ['check-auth']], function (Router $router) {
    $router->post('register', [
        'as' => 'api.shop.shop.register',
        'uses' => 'ShopController@store'
    ]);
});
