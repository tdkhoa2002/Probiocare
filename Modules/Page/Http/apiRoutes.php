<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/page', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('pages', [
        'as' => 'api.page.page.index',
        'uses' => 'PageController@index',
        'middleware' => 'token-can:page.pages.index',
    ]);
    $router->get('pages-server-side', [
        'as' => 'api.page.page.indexServerSide',
        'uses' => 'PageController@indexServerSide',
        'middleware' => 'token-can:page.pages.index',
    ]);
    $router->get('mark-pages-status', [
        'as' => 'api.page.page.mark-status',
        'uses' => 'UpdatePageStatusController',
        'middleware' => 'token-can:page.pages.edit',
    ]);
    $router->delete('pages/{page}', [
        'as' => 'api.page.page.destroy',
        'uses' => 'PageController@destroy',
        'middleware' => 'token-can:page.pages.destroy',
    ]);
    $router->post('pages', [
        'as' => 'api.page.page.store',
        'uses' => 'PageController@store',
        'middleware' => 'token-can:page.pages.create',
    ]);
    $router->post('pages/{page}', [
        'as' => 'api.page.page.find',
        'uses' => 'PageController@find',
        'middleware' => 'token-can:page.pages.edit',
    ]);
    $router->post('pages/{page}/edit', [
        'as' => 'api.page.page.update',
        'uses' => 'PageController@update',
        'middleware' => 'token-can:page.pages.edit',
    ]);

    $router->get('page-categories', [
        'as' => 'api.page.category.indexServerSide',
        'uses' => 'CategoryController@indexServerSide',
    ]);
    $router->get('page-categories-all', [
        'as' => 'api.page.category.all',
        'uses' => 'CategoryController@all',
    ]);
    $router->get('page-categories-with-children', [
        'as' => 'api.page.category.with.children',
        'uses' => 'CategoryController@getCategoriesWithChildren',
    ]);
    $router->get('page-categories-with-floor', [
        'as' => 'api.page.category.with.floor',
        'uses' => 'CategoryController@getCategoriesWithFloor',
    ]);

    $router->get('templates/{directory}', 'PageTemplatesController')->name('api.page.page-templates.index');
});

$router->group(['prefix' => '/post', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('posts', [
        'as' => 'api.post.post.index',
        'uses' => 'PostController@index',
        'middleware' => 'token-can:post.posts.index',
    ]);
    $router->get('posts-server-side', [
        'as' => 'api.post.post.indexServerSide',
        'uses' => 'PostController@indexServerSide',
        'middleware' => 'token-can:post.posts.index',
    ]);
    $router->get('mark-posts-status', [
        'as' => 'api.post.post.mark-status',
        'uses' => 'UpdatePageStatusController',
        'middleware' => 'token-can:post.posts.edit',
    ]);
    $router->delete('posts/{post}', [
        'as' => 'api.post.post.destroy',
        'uses' => 'PostController@destroy',
        'middleware' => 'token-can:post.posts.destroy',
    ]);
    $router->post('posts', [
        'as' => 'api.post.post.store',
        'uses' => 'PostController@store',
        'middleware' => 'token-can:post.posts.create',
    ]);
    $router->post('posts/{post}', [
        'as' => 'api.post.post.find',
        'uses' => 'PostController@find',
        'middleware' => 'token-can:post.posts.edit',
    ]);
    $router->post('posts/{post}/edit', [
        'as' => 'api.post.post.update',
        'uses' => 'PostController@update',
        'middleware' => 'token-can:post.posts.edit',
    ]);

    $router->get('post-categories', [
        'as' => 'api.post.category.indexServerSide',
        'uses' => 'CategoryController@indexServerSide',
    ]);
    $router->get('post-categories-all', [
        'as' => 'api.post.category.all',
        'uses' => 'CategoryController@all',
    ]);
    $router->get('post-categories-with-children', [
        'as' => 'api.post.category.with.children',
        'uses' => 'CategoryController@getCategoriesWithChildren',
    ]);
    $router->get('post-categories-with-floor', [
        'as' => 'api.post.category.with.floor',
        'uses' => 'CategoryController@getCategoriesWithFloor',
    ]);

    $router->get('post-categories/{categoryId}', [
        'as' => 'api.post.category.find',
        'uses' => 'CategoryController@find',
    ]);

    $router->post('post-categories', [
        'as' => 'api.post.category.store',
        'uses' => 'CategoryController@store',
    ]);
    $router->post('post-categories/{category}', [
        'as' => 'api.post.category.update',
        'uses' => 'CategoryController@update',
    ]);
    $router->delete('post-categories/{category}', [
        'as' => 'api.post.category.destroy',
        'uses' => 'CategoryController@destroy',
    ]);

    $router->get('templates/{directory}', 'PageTemplatesController')->name('api.post.post-templates.index');
});
