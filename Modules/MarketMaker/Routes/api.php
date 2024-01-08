<?php

use Illuminate\Routing\Router;

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

$router->group(['prefix' => '/market-maker', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('targetprices', [
        'as' => 'api.marketmaker.targetprice.indexServerSide',
        'uses' => 'ApiTargetPriceController@indexServerSide',
        'middleware' => 'token-can:marketmaker.targetprices.index'
    ]);
    $router->get('/targetprices/getBotTrade', [
        'as' => 'api.marketmaker.targetprice.getBotTrade',
        'uses' => 'ApiTargetPriceController@getSettingCustomerBot',
        'middleware' => 'token-can:marketmaker.targetprices.index'
    ]);
    $router->get('/targetprices/{targetprice}/edit', [
        'as' => 'api.marketmaker.targetprice.find',
        'uses' => 'ApiTargetPriceController@find',
        'middleware' => 'token-can:marketmaker.targetprices.index'
    ]);
    $router->post('/targetprices', [
        'as' => 'api.marketmaker.targetprice.store',
        'uses' => 'ApiTargetPriceController@store',
        'middleware' => 'token-can:marketmaker.targetprices.index'
    ]);
    $router->post('/targetprices/{targetprice}/update', [
        'as' => 'api.marketmaker.targetprice.update',
        'uses' => 'ApiTargetPriceController@update',
        'middleware' => 'token-can:marketmaker.targetprices.index'
    ]);
    $router->delete('/targetprices/{targetprice}', [
        'as' => 'api.marketmaker.targetprice.delete',
        'uses' => 'ApiTargetPriceController@delete',
        'middleware' => 'token-can:marketmaker.targetprices.index'
    ]);
    $router->post('/targetprices/setBotTrade', [
        'as' => 'api.marketmaker.targetprice.setBotTrade',
        'uses' => 'ApiTargetPriceController@saveSettingCustomerBot',
        'middleware' => 'token-can:marketmaker.targetprices.index'
    ]);
    

    $router->get('volumnizers', [
        'as' => 'api.marketmaker.volumnizer.indexServerSide',
        'uses' => 'ApiVolumnizerController@indexServerSide',
        'middleware' => 'token-can:marketmaker.volumnizers.index'
    ]);

    $router->post('volumnizers', [
        'as' => 'api.marketmaker.volumnizer.store',
        'uses' => 'ApiVolumnizerController@store',
        'middleware' => 'token-can:marketmaker.volumnizers.index'
    ]);

    $router->get('volumnizers/{volumnizer}/edit', [
        'as' => 'api.marketmaker.volumnizer.find',
        'uses' => 'ApiVolumnizerController@find',
        'middleware' => 'token-can:marketmaker.volumnizers.index'
    ]);

    $router->post('volumnizers/{volumnizer}/update', [
        'as' => 'api.marketmaker.volumnizer.update',
        'uses' => 'ApiVolumnizerController@update',
        'middleware' => 'token-can:marketmaker.volumnizers.index'
    ]);

    $router->delete('volumnizers/{volumnizer}', [
        'as' => 'api.marketmaker.volumnizer.delete',
        'uses' => 'ApiVolumnizerController@delete',
        'middleware' => 'token-can:marketmaker.volumnizers.index'
    ]);
});