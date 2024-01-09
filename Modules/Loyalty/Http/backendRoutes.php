<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/loyalty'], function (Router $router) {
    $router->bind('package', function ($id) {
        return app('Modules\Loyalty\Repositories\PackageRepository')->find($id);
    });
    $router->get('packages', [
        'as' => 'admin.loyalty.package.index',
        'uses' => 'PackageController@index',
        'middleware' => 'can:loyalty.packages.index'
    ]);
    $router->get('packages/create', [
        'as' => 'admin.loyalty.package.create',
        'uses' => 'PackageController@create',
        'middleware' => 'can:loyalty.packages.create'
    ]);
    $router->post('packages', [
        'as' => 'admin.loyalty.package.store',
        'uses' => 'PackageController@store',
        'middleware' => 'can:loyalty.packages.create'
    ]);
    $router->get('packages/{package}/edit', [
        'as' => 'admin.loyalty.package.edit',
        'uses' => 'PackageController@edit',
        'middleware' => 'can:loyalty.packages.edit'
    ]);
    $router->put('packages/{package}', [
        'as' => 'admin.loyalty.package.update',
        'uses' => 'PackageController@update',
        'middleware' => 'can:loyalty.packages.edit'
    ]);
    $router->delete('packages/{package}', [
        'as' => 'admin.loyalty.package.destroy',
        'uses' => 'PackageController@destroy',
        'middleware' => 'can:loyalty.packages.destroy'
    ]);
// append

});
