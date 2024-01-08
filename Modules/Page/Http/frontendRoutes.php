<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->get('/', [
    'uses' => 'PublicController@homepage',
    'as' => 'homepage',
    'middleware' => config('asgard.page.config.middleware'),
]);
$router->any('{uri}', [
    'uses' => 'PublicController@uri',
    'as' => 'page',
    'middleware' => config('asgard.page.config.middleware'),
]);

$router->get('/category/{cate}', [
    'uses' => 'PublicController@getCategory',
    'as' => 'docs.get.post',
    'middleware' => config('asgard.page.config.middleware'),
]);
