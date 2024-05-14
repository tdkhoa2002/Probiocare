<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/setting'], function (Router $router) {
    $router->get('settings/{module}', [
        'as' => 'dashboard.module.settings',
        'uses' => 'SettingController@getModuleSettings',
        'middleware' => 'can:setting.settings.index',
    ]);
    $router->get('settings', [
        'as' => 'admin.setting.settings.index',
        'uses' => 'SettingController@index',
        'middleware' => 'can:setting.settings.index',
    ]);
    $router->post('settings', [
        'as' => 'admin.setting.settings.store',
        'uses' => 'SettingController@store',
        'middleware' => 'can:setting.settings.edit',
    ]);
});
$router->group(['prefix' => '/theme-option'], function (Router $router) {
    $router->get('theme-options', [
        'as' => 'admin.themeoption.themeoptions.index',
        'uses' => 'ThemeOptionController@index',
        'middleware' => 'can:themeoption.themeoptions.index',
    ]);

    $router->post('theme-options', [
        'as' => 'admin.themeoption.themeoptions.store',
        'uses' => 'ThemeOptionController@store',
        'middleware' => 'can:themeoption.themeoptions.edit',
    ]);
});
