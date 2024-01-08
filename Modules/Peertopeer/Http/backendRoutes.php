<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/peertopeer'], function (Router $router) {
    $router->bind('ads', function ($id) {
        return app('Modules\Peertopeer\Repositories\AdsRepository')->find($id);
    });
    $router->get('ads', [
        'as' => 'admin.peertopeer.ads.index',
        'uses' => 'AdsController@index',
        'middleware' => 'can:peertopeer.ads.index'
    ]);
    $router->get('ads/create', [
        'as' => 'admin.peertopeer.ads.create',
        'uses' => 'AdsController@create',
        'middleware' => 'can:peertopeer.ads.create'
    ]);
    $router->post('ads', [
        'as' => 'admin.peertopeer.ads.store',
        'uses' => 'AdsController@store',
        'middleware' => 'can:peertopeer.ads.create'
    ]);
    $router->get('ads/{ads}/edit', [
        'as' => 'admin.peertopeer.ads.edit',
        'uses' => 'AdsController@edit',
        'middleware' => 'can:peertopeer.ads.edit'
    ]);
    $router->put('ads/{ads}', [
        'as' => 'admin.peertopeer.ads.update',
        'uses' => 'AdsController@update',
        'middleware' => 'can:peertopeer.ads.edit'
    ]);
    $router->delete('ads/{ads}', [
        'as' => 'admin.peertopeer.ads.destroy',
        'uses' => 'AdsController@destroy',
        'middleware' => 'can:peertopeer.ads.destroy'
    ]);
    $router->bind('order', function ($id) {
        return app('Modules\Peertopeer\Repositories\OrderRepository')->find($id);
    });
    $router->get('orders', [
        'as' => 'admin.peertopeer.order.index',
        'uses' => 'OrderController@index',
        'middleware' => 'can:peertopeer.orders.index'
    ]);
    $router->get('orders/create', [
        'as' => 'admin.peertopeer.order.create',
        'uses' => 'OrderController@create',
        'middleware' => 'can:peertopeer.orders.create'
    ]);
    $router->post('orders', [
        'as' => 'admin.peertopeer.order.store',
        'uses' => 'OrderController@store',
        'middleware' => 'can:peertopeer.orders.create'
    ]);
    $router->get('orders/{order}/edit', [
        'as' => 'admin.peertopeer.order.edit',
        'uses' => 'OrderController@edit',
        'middleware' => 'can:peertopeer.orders.edit'
    ]);
    $router->put('orders/{order}', [
        'as' => 'admin.peertopeer.order.update',
        'uses' => 'OrderController@update',
        'middleware' => 'can:peertopeer.orders.edit'
    ]);
    $router->delete('orders/{order}', [
        'as' => 'admin.peertopeer.order.destroy',
        'uses' => 'OrderController@destroy',
        'middleware' => 'can:peertopeer.orders.destroy'
    ]);
    $router->bind('orderhistory', function ($id) {
        return app('Modules\Peertopeer\Repositories\OrderHistoryRepository')->find($id);
    });
    $router->get('orderhistories', [
        'as' => 'admin.peertopeer.orderhistory.index',
        'uses' => 'OrderHistoryController@index',
        'middleware' => 'can:peertopeer.orderhistories.index'
    ]);
    $router->get('orderhistories/create', [
        'as' => 'admin.peertopeer.orderhistory.create',
        'uses' => 'OrderHistoryController@create',
        'middleware' => 'can:peertopeer.orderhistories.create'
    ]);
    $router->post('orderhistories', [
        'as' => 'admin.peertopeer.orderhistory.store',
        'uses' => 'OrderHistoryController@store',
        'middleware' => 'can:peertopeer.orderhistories.create'
    ]);
    $router->get('orderhistories/{orderhistory}/edit', [
        'as' => 'admin.peertopeer.orderhistory.edit',
        'uses' => 'OrderHistoryController@edit',
        'middleware' => 'can:peertopeer.orderhistories.edit'
    ]);
    $router->put('orderhistories/{orderhistory}', [
        'as' => 'admin.peertopeer.orderhistory.update',
        'uses' => 'OrderHistoryController@update',
        'middleware' => 'can:peertopeer.orderhistories.edit'
    ]);
    $router->delete('orderhistories/{orderhistory}', [
        'as' => 'admin.peertopeer.orderhistory.destroy',
        'uses' => 'OrderHistoryController@destroy',
        'middleware' => 'can:peertopeer.orderhistories.destroy'
    ]);
    $router->bind('chat', function ($id) {
        return app('Modules\Peertopeer\Repositories\ChatRepository')->find($id);
    });
    $router->get('chats', [
        'as' => 'admin.peertopeer.chat.index',
        'uses' => 'ChatController@index',
        'middleware' => 'can:peertopeer.chats.index'
    ]);
    $router->get('chats/create', [
        'as' => 'admin.peertopeer.chat.create',
        'uses' => 'ChatController@create',
        'middleware' => 'can:peertopeer.chats.create'
    ]);
    $router->post('chats', [
        'as' => 'admin.peertopeer.chat.store',
        'uses' => 'ChatController@store',
        'middleware' => 'can:peertopeer.chats.create'
    ]);
    $router->get('chats/{chat}/edit', [
        'as' => 'admin.peertopeer.chat.edit',
        'uses' => 'ChatController@edit',
        'middleware' => 'can:peertopeer.chats.edit'
    ]);
    $router->put('chats/{chat}', [
        'as' => 'admin.peertopeer.chat.update',
        'uses' => 'ChatController@update',
        'middleware' => 'can:peertopeer.chats.edit'
    ]);
    $router->delete('chats/{chat}', [
        'as' => 'admin.peertopeer.chat.destroy',
        'uses' => 'ChatController@destroy',
        'middleware' => 'can:peertopeer.chats.destroy'
    ]);
    $router->bind('adspaymentmethod', function ($id) {
        return app('Modules\Peertopeer\Repositories\AdsPaymentMethodRepository')->find($id);
    });
    $router->get('adspaymentmethods', [
        'as' => 'admin.peertopeer.adspaymentmethod.index',
        'uses' => 'AdsPaymentMethodController@index',
        'middleware' => 'can:peertopeer.adspaymentmethods.index'
    ]);
    $router->get('adspaymentmethods/create', [
        'as' => 'admin.peertopeer.adspaymentmethod.create',
        'uses' => 'AdsPaymentMethodController@create',
        'middleware' => 'can:peertopeer.adspaymentmethods.create'
    ]);
    $router->post('adspaymentmethods', [
        'as' => 'admin.peertopeer.adspaymentmethod.store',
        'uses' => 'AdsPaymentMethodController@store',
        'middleware' => 'can:peertopeer.adspaymentmethods.create'
    ]);
    $router->get('adspaymentmethods/{adspaymentmethod}/edit', [
        'as' => 'admin.peertopeer.adspaymentmethod.edit',
        'uses' => 'AdsPaymentMethodController@edit',
        'middleware' => 'can:peertopeer.adspaymentmethods.edit'
    ]);
    $router->put('adspaymentmethods/{adspaymentmethod}', [
        'as' => 'admin.peertopeer.adspaymentmethod.update',
        'uses' => 'AdsPaymentMethodController@update',
        'middleware' => 'can:peertopeer.adspaymentmethods.edit'
    ]);
    $router->delete('adspaymentmethods/{adspaymentmethod}', [
        'as' => 'admin.peertopeer.adspaymentmethod.destroy',
        'uses' => 'AdsPaymentMethodController@destroy',
        'middleware' => 'can:peertopeer.adspaymentmethods.destroy'
    ]);
// append





});
