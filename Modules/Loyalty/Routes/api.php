<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Routing\Router;

$router->group(['prefix' => '/loyalty', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('packages', [
        'as' => 'api.loyalty.package.indexServerSide',
        'uses' => 'PackageAdminController@indexServerSide',
        'middleware' => 'token-can:loyalty.packages.index',
    ]);
    $router->get('packages/{packageId}', [
        'as' => 'api.loyalty.package.find',
        'uses' => 'PackageAdminController@find',
        'middleware' => 'token-can:loyalty.packages.index',
    ]);

    $router->post('packages', [
        'as' => 'api.loyalty.package.store',
        'uses' => 'PackageAdminController@store',
        'middleware' => 'token-can:loyalty.packages.create',
    ]);
    $router->post('packages/{package}', [
        'as' => 'api.loyalty.package.update',
        'uses' => 'PackageAdminController@update',
        'middleware' => 'token-can:loyalty.packages.edit',
    ]);
    $router->delete('packages/{package}', [
        'as' => 'api.loyalty.package.destroy',
        'uses' => 'PackageAdminController@destroy',
        'middleware' => 'token-can:loyalty.packages.destroy',
    ]);

    // $router->get('package-terms/{packageId}', [
    //     'as' => 'api.staking.packageterm.indexServerSide',
    //     'uses' => 'PackageTermAdminController@indexServerSide',
    //     'middleware' => 'token-can:staking.packages.index',
    // ]);
    // $router->post('package-terms/{packageId}/store', [
    //     'as' => 'api.staking.packageTerm.store',
    //     'uses' => 'PackageTermAdminController@store',
    //     'middleware' => 'token-can:staking.packages.create',
    // ]);
    // $router->post('package-terms/{packageTermId}/update', [
    //     'as' => 'api.staking.packageTerm.update',
    //     'uses' => 'PackageTermAdminController@update',
    //     'middleware' => 'token-can:staking.packages.edit',
    // ]);
    // $router->get('packages-terms/{packageTermId}', [
    //     'as' => 'api.staking.packageTerm.find',
    //     'uses' => 'PackageTermAdminController@find',
    //     'middleware' => 'token-can:staking.packages.index',
    // ]);
    // $router->delete('package-terms/{packageterm}', [
    //     'as' => 'api.staking.packageTerm.destroy',
    //     'uses' => 'PackageTermAdminController@destroy',
    //     'middleware' => 'token-can:staking.packages.destroy',
    // ]);
    
    // $router->get('commissions/{packageId}', [
    //     'as' => 'api.staking.commission.indexServerSide',
    //     'uses' => 'CommissionAdminController@indexServerSide',
    //     'middleware' => 'token-can:staking.packages.index',
    // ]);
    // $router->post('commissions/{packageId}/store', [
    //     'as' => 'api.staking.commission.store',
    //     'uses' => 'CommissionAdminController@store',
    //     'middleware' => 'token-can:staking.packages.create',
    // ]);
    // $router->post('commissions/{packageId}/quick-store', [
    //     'as' => 'api.staking.commission.quickStore',
    //     'uses' => 'CommissionAdminController@quickStore',
    //     'middleware' => 'token-can:staking.packages.create',
    // ]);
    // $router->post('commissions/{commissionId}/update', [
    //     'as' => 'api.staking.commission.update',
    //     'uses' => 'CommissionAdminController@update',
    //     'middleware' => 'token-can:staking.packages.edit',
    // ]);
    // $router->get('commissions/{commissionId}/find', [
    //     'as' => 'api.staking.commission.find',
    //     'uses' => 'CommissionAdminController@find',
    //     'middleware' => 'token-can:staking.packages.index',
    // ]);
    // $router->delete('commissions/{commission}', [
    //     'as' => 'api.staking.commission.destroy',
    //     'uses' => 'CommissionAdminController@destroy',
    //     'middleware' => 'token-can:staking.packages.destroy',
    // ]);

    // $router->get('orders', [
    //     'as' => 'api.staking.order.indexServerSide',
    //     'uses' => 'OrderAdminController@indexServerSide',
    //     'middleware' => 'token-can:staking.orders.index',
    // ]);

    // $router->get('order/{order}', [
    //     'as' => 'api.staking.order.detail',
    //     'uses' => 'OrderAdminController@detail',
    //     'middleware' => 'token-can:staking.orders.detail',
    // ]);
    // $router->get('order-transaction/{orderId}', [
    //     'as' => 'api.staking.order.transaction',
    //     'uses' => 'OrderAdminController@getTransaction',
    //     'middleware' => 'token-can:staking.orders.detail',
    // ]);
});