<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/marketmaker'], function (Router $router) {
    $router->bind('targetprice', function ($id) {
        return app('Modules\MarketMaker\Repositories\TargetPriceRepository')->find($id);
    });
    $router->get('targetprices', [
        'as' => 'admin.marketmaker.targetprice.index',
        'uses' => 'TargetPriceController@index',
        'middleware' => 'can:marketmaker.targetprices.index'
    ]);
    $router->get('targetprices/create', [
        'as' => 'admin.marketmaker.targetprice.create',
        'uses' => 'TargetPriceController@create',
        'middleware' => 'can:marketmaker.targetprices.create'
    ]);
    $router->post('targetprices', [
        'as' => 'admin.marketmaker.targetprice.store',
        'uses' => 'TargetPriceController@store',
        'middleware' => 'can:marketmaker.targetprices.create'
    ]);
    $router->get('targetprices/{targetprice}/edit', [
        'as' => 'admin.marketmaker.targetprice.edit',
        'uses' => 'TargetPriceController@edit',
        'middleware' => 'can:marketmaker.targetprices.edit'
    ]);
    $router->put('targetprices/{targetprice}', [
        'as' => 'admin.marketmaker.targetprice.update',
        'uses' => 'TargetPriceController@update',
        'middleware' => 'can:marketmaker.targetprices.edit'
    ]);
    $router->delete('targetprices/{targetprice}', [
        'as' => 'admin.marketmaker.targetprice.destroy',
        'uses' => 'TargetPriceController@destroy',
        'middleware' => 'can:marketmaker.targetprices.destroy'
    ]);
    $router->bind('volumnizer', function ($id) {
        return app('Modules\MarketMaker\Repositories\VolumnizerRepository')->find($id);
    });
    $router->get('volumnizers', [
        'as' => 'admin.marketmaker.volumnizer.index',
        'uses' => 'VolumnizerController@index',
        'middleware' => 'can:marketmaker.volumnizers.index'
    ]);
    $router->get('volumnizers/create', [
        'as' => 'admin.marketmaker.volumnizer.create',
        'uses' => 'VolumnizerController@create',
        'middleware' => 'can:marketmaker.volumnizers.create'
    ]);
    $router->post('volumnizers', [
        'as' => 'admin.marketmaker.volumnizer.store',
        'uses' => 'VolumnizerController@store',
        'middleware' => 'can:marketmaker.volumnizers.create'
    ]);
    $router->get('volumnizers/{volumnizer}/edit', [
        'as' => 'admin.marketmaker.volumnizer.edit',
        'uses' => 'VolumnizerController@edit',
        'middleware' => 'can:marketmaker.volumnizers.edit'
    ]);
    $router->put('volumnizers/{volumnizer}', [
        'as' => 'admin.marketmaker.volumnizer.update',
        'uses' => 'VolumnizerController@update',
        'middleware' => 'can:marketmaker.volumnizers.edit'
    ]);
    $router->delete('volumnizers/{volumnizer}', [
        'as' => 'admin.marketmaker.volumnizer.destroy',
        'uses' => 'VolumnizerController@destroy',
        'middleware' => 'can:marketmaker.volumnizers.destroy'
    ]);
// append


});
