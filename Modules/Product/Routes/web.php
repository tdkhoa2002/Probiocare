<?php
use Illuminate\Routing\Router;

$router->get('/' . trans('product::products.router.product') . '/' . trans('product::products.router.search'), [
    'as' => 'fe.product.product.search', 'uses' => 'PublicController@search'
]);
$router->get('/' . trans('product::products.router.product') . '/{slug}', ['as' => 'fe.product.product.detail', 'uses' => 'PublicController@detail']);
$router->get('/' . trans('product::products.router.category') . '/{slug}', ['as' => 'fe.product.product.category', 'uses' => 'PublicController@getProductByCategory']);
