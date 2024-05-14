<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/product', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('categories', [
        'as' => 'api.product.category.indexServerSide',
        'uses' => 'CategoryController@indexServerSide',
        'middleware' => 'can:product.categories.index'
    ]);
    $router->get('categories-with-children', [
        'as' => 'api.product.category.with.children',
        'uses' => 'CategoryController@getCategoriesWithChildren',
    ]);
    $router->get('categories/all', [
        'as' => 'api.product.category.all',
        'uses' => 'CategoryController@all',
        'middleware' => 'can:product.categories.index'
    ]);
    
    $router->get('categories/all', [
        'as' => 'api.product.category.all',
        'uses' => 'CategoryController@all',
        'middleware' => 'can:product.categories.index'
    ]);
    $router->post('categories/create', [
        'as' => 'api.product.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:product.categories.create'
    ]);
    $router->get('categories/find', [
        'as' => 'api.product.category.find',
        'uses' => 'CategoryController@find',
        'middleware' => 'can:product.categories.index'
    ]);
    $router->post('categories/{categoryId}/update', [
        'as' => 'api.product.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:product.categories.edit'
    ]);
    $router->delete('categories/{categoryId}/destroy', [
        'as' => 'api.product.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:product.categories.destroy'
    ]);


    $router->get('products', [
        'as' => 'api.product.product.indexServerSide',
        'uses' => 'ProductController@indexServerSide',
        'middleware' => 'can:product.products.index'
    ]);
    $router->post('products/create', [
        'as' => 'api.product.product.store',
        'uses' => 'ProductController@store',
        'middleware' => 'can:product.products.create'
    ]);
    $router->get('products/find', [
        'as' => 'api.product.product.find',
        'uses' => 'ProductController@find',
        'middleware' => 'can:product.products.index'
    ]);
    $router->post('products/{productId}/update', [
        'as' => 'api.product.product.update',
        'uses' => 'ProductController@update',
        'middleware' => 'can:product.products.edit'
    ]);
    $router->delete('products/{productId}/destroy', [
        'as' => 'api.product.product.destroy',
        'uses' => 'ProductController@destroy',
        'middleware' => 'can:product.products.destroy'
    ]);
});
