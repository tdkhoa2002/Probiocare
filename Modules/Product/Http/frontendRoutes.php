<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->get('/san-pham/tim-kiem', ['as' => 'fe.product.product.search','uses' => 'PublicController@search']);
$router->get('/san-pham/{slug}', ['as' => 'fe.product.product.detail','uses' => 'PublicController@detail']);
$router->get('/danh-muc/{slug}', ['as' => 'fe.product.product.category','uses' => 'PublicController@getProductByCategory']);
