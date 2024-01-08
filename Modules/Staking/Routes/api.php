<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/** @var Router $router */

use Illuminate\Routing\Router;

$router->group(['prefix' => '/staking', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('packages', [
        'as' => 'api.staking.package.indexServerSide',
        'uses' => 'PackageAdminController@indexServerSide',
        'middleware' => 'token-can:staking.packages.index',
    ]);
    $router->get('packages/{packageId}', [
        'as' => 'api.staking.package.find',
        'uses' => 'PackageAdminController@find',
        'middleware' => 'token-can:staking.packages.index',
    ]);

    $router->post('packages', [
        'as' => 'api.staking.package.store',
        'uses' => 'PackageAdminController@store',
        'middleware' => 'token-can:staking.packages.create',
    ]);
    $router->post('packages/{package}', [
        'as' => 'api.staking.package.update',
        'uses' => 'PackageAdminController@update',
        'middleware' => 'token-can:staking.packages.edit',
    ]);
    $router->delete('packages/{package}', [
        'as' => 'api.staking.package.destroy',
        'uses' => 'PackageAdminController@destroy',
        'middleware' => 'token-can:staking.packages.destroy',
    ]);

    $router->get('package-terms/{packageId}', [
        'as' => 'api.staking.packageterm.indexServerSide',
        'uses' => 'PackageTermAdminController@indexServerSide',
        'middleware' => 'token-can:staking.packages.index',
    ]);
    $router->post('package-terms/{packageId}/store', [
        'as' => 'api.staking.packageTerm.store',
        'uses' => 'PackageTermAdminController@store',
        'middleware' => 'token-can:staking.packages.create',
    ]);
    $router->post('package-terms/{packageTermId}/update', [
        'as' => 'api.staking.packageTerm.update',
        'uses' => 'PackageTermAdminController@update',
        'middleware' => 'token-can:staking.packages.edit',
    ]);
    $router->get('packages-terms/{packageTermId}', [
        'as' => 'api.staking.packageTerm.find',
        'uses' => 'PackageTermAdminController@find',
        'middleware' => 'token-can:staking.packages.index',
    ]);
    $router->delete('package-terms/{packageterm}', [
        'as' => 'api.staking.packageTerm.destroy',
        'uses' => 'PackageTermAdminController@destroy',
        'middleware' => 'token-can:staking.packages.destroy',
    ]);
    
    $router->get('commissions/{packageId}', [
        'as' => 'api.staking.commission.indexServerSide',
        'uses' => 'CommissionAdminController@indexServerSide',
        'middleware' => 'token-can:staking.packages.index',
    ]);
    $router->post('commissions/{packageId}/store', [
        'as' => 'api.staking.commission.store',
        'uses' => 'CommissionAdminController@store',
        'middleware' => 'token-can:staking.packages.create',
    ]);
    $router->post('commissions/{packageId}/quick-store', [
        'as' => 'api.staking.commission.quickStore',
        'uses' => 'CommissionAdminController@quickStore',
        'middleware' => 'token-can:staking.packages.create',
    ]);
    $router->post('commissions/{commissionId}/update', [
        'as' => 'api.staking.commission.update',
        'uses' => 'CommissionAdminController@update',
        'middleware' => 'token-can:staking.packages.edit',
    ]);
    $router->get('commissions/{commissionId}/find', [
        'as' => 'api.staking.commission.find',
        'uses' => 'CommissionAdminController@find',
        'middleware' => 'token-can:staking.packages.index',
    ]);
    $router->delete('commissions/{commission}', [
        'as' => 'api.staking.commission.destroy',
        'uses' => 'CommissionAdminController@destroy',
        'middleware' => 'token-can:staking.packages.destroy',
    ]);

    $router->get('orders', [
        'as' => 'api.staking.order.indexServerSide',
        'uses' => 'OrderAdminController@indexServerSide',
        'middleware' => 'token-can:staking.orders.index',
    ]);

    $router->get('order/{order}', [
        'as' => 'api.staking.order.detail',
        'uses' => 'OrderAdminController@detail',
        'middleware' => 'token-can:staking.orders.detail',
    ]);
    $router->get('order-transaction/{orderId}', [
        'as' => 'api.staking.order.transaction',
        'uses' => 'OrderAdminController@getTransaction',
        'middleware' => 'token-can:staking.orders.detail',
    ]);
});
$router->group(['prefix' => '/staking', 'middleware' => ['api.token', 'auth.admin'],'namespace'=>'Admin'], function (Router $router) {
    $router->get('report/report-total', [
        'as' => 'api.staking.report.reportTotal',
        'uses' => 'ReportController@reportTotal',
        'middleware' => 'token-can:staking.orders.index',
    ]);
});

Route::prefix('public/staking')->group(function () {
    Route::get('/list-packages', 'PackagesController@getPackagesList')->name('fe.staking.staking.get-packages-list');
});