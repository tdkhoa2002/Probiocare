<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/customer', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('customers', [
        'as' => 'api.customer.customer.indexServerSide',
        'uses' => 'CustomerController@indexServerSide',
        'middleware' => 'token-can:customer.customers.index',
    ]);
    $router->get('allwithfilter', [
        'as' => 'api.customer.customer.allwithfilter',
        'uses' => 'CustomerController@allWithFilter',
        'middleware' => 'token-can:customer.customers.index',
    ]);
    $router->get('customers/{customerId}', [
        'as' => 'api.customer.customer.find',
        'uses' => 'CustomerController@find',
        'middleware' => 'token-can:customer.customers.index',
    ]);
    
    $router->post('customers', [
        'as' => 'api.customer.customer.store',
        'uses' => 'CustomerController@store',
        'middleware' => 'token-can:customer.customers.create',
    ]);
    $router->post('customers/{customer}', [
        'as' => 'api.customer.customer.update',
        'uses' => 'CustomerController@update',
        'middleware' => 'token-can:customer.customers.edit',
    ]);
    $router->delete('customers/{customer}', [
        'as' => 'api.customer.customer.destroy',
        'uses' => 'CustomerController@destroy',
        'middleware' => 'token-can:customer.customers.destroy',
    ]);

    $router->get('customerKyc/{customerId}', [
        'as' => 'api.customer.customerKyc.find',
        'uses' => 'CustomerKycController@find',
        'middleware' => 'token-can:customer.customers.edit',
    ]);
    $router->post('update-customerKyc/{customerId}', [
        'as' => 'api.customer.customerKyc.update',
        'uses' => 'CustomerKycController@update',
        'middleware' => 'token-can:customer.customers.edit',
    ]);


    $router->get('paymentmethods', [
        'as' => 'api.customer.paymentmethod.indexServerSide',
        'uses' => 'PaymentmethodController@indexServerSide',
        'middleware' => 'token-can:customer.paymentmethods.index',
    ]);
    $router->get('allWithFilter', [
        'as' => 'api.customer.paymentmethod.allWithFilter',
        'uses' => 'PaymentmethodController@allWithFilter',
        'middleware' => 'token-can:customer.paymentmethods.index',
    ]);
    $router->get('paymentmethods/{paymentmethodId}', [
        'as' => 'api.customer.paymentmethod.find',
        'uses' => 'PaymentmethodController@find',
        'middleware' => 'token-can:customer.paymentmethods.index',
    ]);
    
    $router->post('paymentmethods', [
        'as' => 'api.customer.paymentmethod.store',
        'uses' => 'PaymentmethodController@store',
        'middleware' => 'token-can:customer.paymentmethods.create',
    ]);
    $router->post('paymentmethods/{paymentmethod}', [
        'as' => 'api.customer.paymentmethod.update',
        'uses' => 'PaymentmethodController@update',
        'middleware' => 'token-can:customer.paymentmethods.edit',
    ]);
    $router->delete('paymentmethods/{paymentmethod}', [
        'as' => 'api.customer.paymentmethod.destroy',
        'uses' => 'PaymentmethodController@destroy',
        'middleware' => 'token-can:customer.paymentmethods.destroy',
    ]);

    $router->get('paymentmethodattrs/{paymentmethodId}', [
        'as' => 'api.customer.paymentmethodattr.indexServerSide',
        'uses' => 'PaymentmethodAttrController@indexServerSide',
        'middleware' => 'token-can:customer.paymentmethods.index',
    ]);

    $router->get('paymentmethodattrs/{paymentmethodId}/{paymentmethodAttrId}', [
        'as' => 'api.customer.paymentmethodattr.find',
        'uses' => 'PaymentmethodAttrController@find',
        'middleware' => 'token-can:customer.paymentmethods.index',
    ]);
    
    $router->post('paymentmethodattrs', [
        'as' => 'api.customer.paymentmethodattr.store',
        'uses' => 'PaymentmethodAttrController@store',
        'middleware' => 'token-can:customer.paymentmethods.create',
    ]);
    $router->post('paymentmethodattrs/{paymentmethodId}/{paymentmethodAttrId}', [
        'as' => 'api.customer.paymentmethodattr.update',
        'uses' => 'PaymentmethodAttrController@update',
        'middleware' => 'token-can:customer.paymentmethods.edit',
    ]);
    $router->delete('paymentmethodattrs/{paymentmethodattr}', [
        'as' => 'api.customer.paymentmethodattr.destroy',
        'uses' => 'PaymentmethodAttrController@destroy',
        'middleware' => 'token-can:customer.paymentmethods.destroy',
    ]);
});