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
    $router->post('packages/{packageLoyalty}', [
        'as' => 'api.loyalty.package.update',
        'uses' => 'PackageAdminController@update',
        'middleware' => 'token-can:loyalty.packages.edit',
    ]);
    $router->delete('packages/{packageLoyalty}', [
        'as' => 'api.loyalty.package.destroy',
        'uses' => 'PackageAdminController@destroy',
        'middleware' => 'token-can:loyalty.packages.destroy',
    ]);

    $router->get('package-terms/{packageId}', [
        'as' => 'api.loyalty.packageterm.indexServerSide',
        'uses' => 'PackageTermAdminController@indexServerSide',
        'middleware' => 'token-can:loyalty.packages.index',
    ]);
    $router->post('package-terms/{packageId}/store', [
        'as' => 'api.loyalty.packageTerm.store',
        'uses' => 'PackageTermAdminController@store',
        'middleware' => 'token-can:loyalty.packages.create',
    ]);
    $router->post('package-terms/{packageTermId}/update', [
        'as' => 'api.loyalty.packageTerm.update',
        'uses' => 'PackageTermAdminController@update',
        'middleware' => 'token-can:loyalty.packages.edit',
    ]);
    $router->get('packages-terms/{packageTermId}', [
        'as' => 'api.loyalty.packageTerm.find',
        'uses' => 'PackageTermAdminController@find',
        'middleware' => 'token-can:loyalty.packages.index',
    ]);
    $router->delete('package-terms/{packagetermLoyalty}', [
        'as' => 'api.loyalty.packageTerm.destroy',
        'uses' => 'PackageTermAdminController@destroy',
        'middleware' => 'token-can:loyalty.packages.destroy',
    ]);
    
    $router->get('commissions/{packageId}', [
        'as' => 'api.loyalty.commission.indexServerSide',
        'uses' => 'CommissionAdminController@indexServerSide',
        'middleware' => 'token-can:loyalty.packages.index',
    ]);
    $router->post('commissions/{packageId}/store', [
        'as' => 'api.loyalty.commission.store',
        'uses' => 'CommissionAdminController@store',
        'middleware' => 'token-can:loyalty.packages.create',
    ]);
    $router->post('commissions/{packageId}/quick-store', [
        'as' => 'api.loyalty.commission.quickStore',
        'uses' => 'CommissionAdminController@quickStore',
        'middleware' => 'token-can:loyalty.packages.create',
    ]);
    $router->post('commissions/{commissionId}/update', [
        'as' => 'api.loyalty.commission.update',
        'uses' => 'CommissionAdminController@update',
        'middleware' => 'token-can:loyalty.packages.edit',
    ]);
    $router->get('commissions/{commissionId}/find', [
        'as' => 'api.loyalty.commission.find',
        'uses' => 'CommissionAdminController@find',
        'middleware' => 'token-can:loyalty.packages.index',
    ]);
    $router->delete('commissions/{commission}', [
        'as' => 'api.loyalty.commission.destroy',
        'uses' => 'CommissionAdminController@destroy',
        'middleware' => 'token-can:loyalty.packages.destroy',
    ]);

    $router->get('orders', [
        'as' => 'api.loyalty.order.indexServerSide',
        'uses' => 'OrderAdminController@indexServerSide',
        'middleware' => 'token-can:loyalty.orders.index',
    ]);

    $router->get('order/{order}', [
        'as' => 'api.loyalty.order.detail',
        'uses' => 'OrderAdminController@detail',
        'middleware' => 'token-can:loyalty.orders.detail',
    ]);
    $router->get('order-transaction/{orderId}', [
        'as' => 'api.loyalty.order.transaction',
        'uses' => 'OrderAdminController@getTransaction',
        'middleware' => 'token-can:loyalty.orders.detail',
    ]);
});
$router->group(['prefix' => '/loyalty', 'middleware' => ['api.token', 'auth.admin'],'namespace'=>'Admin'], function (Router $router) {
    $router->get('report/report-total', [
        'as' => 'api.loyalty.report.reportTotal',
        'uses' => 'ReportController@reportTotal',
        'middleware' => 'token-can:loyalty.orders.index',
    ]);
});

Route::prefix('public/loyalty')->group(function () {
    Route::get('/list-packages', 'PackagesController@getPackagesList')->name('fe.loyalty.loyalty.get-packages-list');
});