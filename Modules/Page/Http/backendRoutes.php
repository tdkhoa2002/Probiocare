<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/page'], function (Router $router) {
    $router->get('pages', [
        'as' => 'admin.page.page.index',
        'uses' => 'PageController@index',
        'middleware' => 'can:page.pages.index',
    ]);
    $router->get('getListPage', [
        'as' => 'admin.page.page.getListPage',
        'uses' => 'PageController@getListPage',
        'middleware' => 'can:page.pages.index',
    ]);
    $router->get('pages/create', [
        'as' => 'admin.page.page.create',
        'uses' => 'PageController@create',
        'middleware' => 'can:page.pages.create',
    ]);
    $router->post('pages', [
        'as' => 'admin.page.page.store',
        'uses' => 'PageController@store',
        'middleware' => 'can:page.pages.create',
    ]);
    $router->get('pages/{page}/edit', [
        'as' => 'admin.page.page.edit',
        'uses' => 'PageController@edit',
        'middleware' => 'can:page.pages.edit',
    ]);
    $router->put('pages/{page}/edit', [
        'as' => 'admin.page.page.update',
        'uses' => 'PageController@update',
        'middleware' => 'can:page.pages.edit',
    ]);
    $router->delete('pages/{page}', [
        'as' => 'admin.page.page.destroy',
        'uses' => 'PageController@destroy',
        'middleware' => 'can:page.pages.destroy',
    ]);
});

$router->group(['prefix' => '/category'], function (Router $router) {
    $router->bind('category', function ($id) {
        return app('Modules\Page\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.category.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:category.categories.index'
    ]);
    $router->get('getListCategory', [
        'as' => 'admin.category.category.getListCategory',
        'uses' => 'CategoryController@getListCategory',
        'middleware' => 'can:category.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.category.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:category.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.category.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:category.categories.create'
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.category.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:category.categories.edit'
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.category.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:category.categories.edit'
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.category.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:category.categories.destroy'
    ]);
});
$router->group(['prefix' => '/post'], function (Router $router) {
    $router->bind('category', function ($id) {
        return app('Modules\Page\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.post.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:post.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.post.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:post.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.post.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:post.categories.create'
    ]);
    $router->get('categories/{category}/edit', [
        'as' => 'admin.post.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:post.categories.edit'
    ]);
    $router->put('categories/{category}', [
        'as' => 'admin.post.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:post.categories.edit'
    ]);
    $router->delete('categories/{category}', [
        'as' => 'admin.post.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:post.categories.destroy'
    ]);

    $router->get('posts', [
        'as' => 'admin.post.post.index',
        'uses' => 'PostController@index',
        'middleware' => 'can:post.posts.index',
    ]);
    $router->get('getListPost', [
        'as' => 'admin.post.post.getListPost',
        'uses' => 'PostController@getListPost',
        'middleware' => 'can:post.posts.index',
    ]);
    $router->get('posts/create', [
        'as' => 'admin.post.post.create',
        'uses' => 'PostController@create',
        'middleware' => 'can:post.posts.create',
    ]);
    $router->post('posts', [
        'as' => 'admin.post.post.store',
        'uses' => 'PostController@store',
        'middleware' => 'can:post.posts.create',
    ]);
    $router->get('posts/{postId}/edit', [
        'as' => 'admin.post.post.edit',
        'uses' => 'PostController@edit',
        'middleware' => 'can:post.posts.edit',
    ]);
    $router->put('posts/{postId}/edit', [
        'as' => 'admin.post.post.update',
        'uses' => 'PostController@update',
        'middleware' => 'can:post.posts.edit',
    ]);
    $router->delete('posts/{postId}', [
        'as' => 'admin.post.post.destroy',
        'uses' => 'PostController@destroy',
        'middleware' => 'can:post.posts.destroy',
    ]);
});
