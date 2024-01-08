<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/affiliate'], function (Router $router) {
    $router->bind('affiliate', function ($id) {
        return app('Modules\Affiliate\Repositories\AffiliateRepository')->find($id);
    });
    $router->get('affiliates', [
        'as' => 'admin.affiliate.affiliate.index',
        'uses' => 'AffiliateController@index',
        'middleware' => 'can:affiliate.affiliates.index'
    ]);
    $router->get('affiliates/create', [
        'as' => 'admin.affiliate.affiliate.create',
        'uses' => 'AffiliateController@create',
        'middleware' => 'can:affiliate.affiliates.create'
    ]);
    $router->post('affiliates', [
        'as' => 'admin.affiliate.affiliate.store',
        'uses' => 'AffiliateController@store',
        'middleware' => 'can:affiliate.affiliates.create'
    ]);
    $router->get('affiliates/{affiliate}/edit', [
        'as' => 'admin.affiliate.affiliate.edit',
        'uses' => 'AffiliateController@edit',
        'middleware' => 'can:affiliate.affiliates.edit'
    ]);
    $router->put('affiliates/{affiliate}', [
        'as' => 'admin.affiliate.affiliate.update',
        'uses' => 'AffiliateController@update',
        'middleware' => 'can:affiliate.affiliates.edit'
    ]);
    $router->delete('affiliates/{affiliate}', [
        'as' => 'admin.affiliate.affiliate.destroy',
        'uses' => 'AffiliateController@destroy',
        'middleware' => 'can:affiliate.affiliates.destroy'
    ]);
// append

});
