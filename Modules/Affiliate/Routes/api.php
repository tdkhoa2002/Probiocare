<?php


use Illuminate\Routing\Router;

$router->group(['prefix' => '/affiliate', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
    $router->get('affiliates', [
        'as' => 'api.affiliate.affiliate.indexServerSide',
        'uses' => 'AffiliateAdminController@indexServerSide',
        'middleware' => 'token-can:affiliate.affiliates.index',
    ]);
    $router->get('affiliates/get-types', [
        'as' => 'api.affiliate.affiliate.getTypeAffiliate',
        'uses' => 'AffiliateAdminController@getTypeAffiliate'
    ]);
    $router->get('affiliates/{affiliateId}', [
        'as' => 'api.affiliate.affiliate.find',
        'uses' => 'AffiliateAdminController@find',
        'middleware' => 'token-can:affiliate.affiliates.index',
    ]);

    $router->post('affiliates', [
        'as' => 'api.affiliate.affiliate.store',
        'uses' => 'AffiliateAdminController@store',
        'middleware' => 'token-can:affiliate.affiliates.create',
    ]);
    $router->post('affiliates/quickStore', [
        'as' => 'api.affiliate.affiliate.quickStore',
        'uses' => 'AffiliateAdminController@quickStore',
        'middleware' => 'token-can:affiliate.affiliates.create',
    ]);
    $router->post('affiliates/{affiliateId}', [
        'as' => 'api.affiliate.affiliate.update',
        'uses' => 'AffiliateAdminController@update',
        'middleware' => 'token-can:affiliate.affiliates.edit',
    ]);
    $router->delete('affiliates/{affiliateId}', [
        'as' => 'api.affiliate.affiliate.destroy',
        'uses' => 'AffiliateAdminController@destroy',
        'middleware' => 'token-can:affiliate.affiliates.destroy',
    ]);
});
