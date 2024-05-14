<?php

use Illuminate\Routing\Router;

$router->bind('group', function ($id) {
    return app('Modules\Dynamicfield\Repositories\GroupRepository')->find($id);
});
$router->bind('page', function ($id) {
    return app('Modules\Page\Repositories\PageRepository')->find($id);
});
$router->group(['prefix' => '/dynamicfield'], function (Router $router) {
    $router->resource('group', 'GroupFieldsController', ['except' => ['show'], 'names' => [
        'index' => 'admin.dynamicfield.group.index',
        'create' => 'admin.dynamicfield.group.create',
        'store' => 'admin.dynamicfield.group.store',
        'update' => 'admin.dynamicfield.group.update',
        'destroy' => 'admin.dynamicfield.group.destroy',
    ]]);
    $router->get('group/edit/{group}', ['as' => 'admin.dynamicfield.group.edit', 'uses' => 'GroupFieldsController@edit', 'middleware' => 'can:dynamicfield.dynamicfields.edit']);
    $router->post('group/renderOption', ['as' => 'admin.dynamicfield.group.renderOption', 'uses' => 'GroupFieldsController@renderOption']);
    $router->post('group/renderRepeaterOption', ['as' => 'admin.dynamicfield.group.renderRepeaterOption', 'uses' => 'GroupFieldsController@renderRepeaterOption']);
    $router->post('group/edit/renderOption', ['as' => 'admin.dynamicfield.group.renderOption', 'uses' => 'GroupFieldsController@renderOption']);
    $router->post('group/edit/renderRepeaterOption', ['as' => 'admin.dynamicfield.group.renderRepeaterOption', 'uses' => 'GroupFieldsController@renderRepeaterOption']);
    $router->post('group/renderControl', ['as' => 'admin.dynamicfield.group.renderControl', 'uses' => 'GroupFieldsController@ajaxRender']);
    $router->post('group/edit/renderLocationDrop', ['as' => 'admin.dynamicfield.group.renderLocationDrop', 'uses' => 'GroupFieldsController@renderLocationDrop']);
    $router->post('group/renderLocationDrop', ['as' => 'admin.dynamicfield.group.renderLocationDrop', 'uses' => 'GroupFieldsController@renderLocationDrop']);

    $router->post('media/link', ['as' => 'admin.dynamicfield.media.linkMedia', 'uses' => 'MediaController@linkMedia']);
    $router->get('page/{page}/duplicate', ['as' => 'admin.dynamicfield.page.duplicate', 'uses' => 'GroupFieldsController@duplicate']);

});
