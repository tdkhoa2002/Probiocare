<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->prefix('cryperrswap')->group(function (Router $router) {
    $router->post('/cal-exchange-price', 'PublicApiController@calExchangePrice');
    $router->post('/exchange', 'PublicApiController@exchange');
    $router->get('/currency', 'PublicApiController@getCurrency');
});
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

$router->prefix('/')->group(function (Router $router) {
    $router->get('/', 'PublicController@index')->name('fe.cryperrswap.swap');
    $router->get('/find', 'PublicController@getFindOrder')->name('fe.cryperrswap.getFindOrder');
    $router->get('/order/{orderCode}', 'PublicController@getTxn')->name('fe.cryperrswap.order');
});
