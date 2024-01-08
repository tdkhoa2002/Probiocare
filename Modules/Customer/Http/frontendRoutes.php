<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->get(trans('customer::customers.routers.login'), ['as' => 'fe.customer.customer.login', 'uses' => 'LoginCustomController@login']);
$router->get(trans('customer::customers.routers.verifyLogin'), ['as' => 'fe.customer.customer.verifyLogin', 'uses' => 'LoginCustomController@verifyLogin']);

$router->get(trans('customer::customers.routers.register'), ['as' => 'fe.customer.customer.register', 'uses' => 'RegisterController@register']);
$router->get(trans('customer::customers.routers.verifyRegister'), ['as' => 'fe.customer.customer.verifyRegister', 'uses' => 'RegisterController@verifyRegister']);

$router->get(trans('customer::customers.routers.forgot'), ['as' => 'fe.customer.customer.forgot', 'uses' => 'ForgotController@forgot']);
$router->get(trans('customer::customers.routers.verify_forgot'), ['as' => 'fe.customer.customer.verifyForgot', 'uses' => 'ForgotController@verifyForgot']);

$router->group(['prefix' => '/customer'], function (Router $router) {
    $router->post('login', ['as' => 'api.customer.customer.postLogin', 'uses' => 'ApiLoginController@postLogin']);
    $router->post('handle-login', ['as' => 'api.customer.customer.hanldeLogin', 'uses' => 'ApiLoginController@hanldeLogin']);

    $router->post('register', ['as' => 'fe.customer.customer.postRegister', 'uses' => 'RegisterController@postRegister']);
    $router->post('hanlde-verify-register', ['as' => 'fe.customer.customer.handleVerifyRegister', 'uses' => 'RegisterController@handleVerifyRegister']);
    $router->post('resend-verify-register', ['as' => 'fe.customer.customer.resendVerifyRegister', 'uses' => 'RegisterController@resendVerifyRegister']);
    $router->post('forgot-password', ['as' => 'fe.customer.customer.forgotPassword', 'uses' => 'ForgotController@forgotPassword']);
    $router->post('verify-change-password', ['as' => 'fe.customer.customer.changePassword', 'uses' => 'ForgotController@changePassword']);
});

$router->group(['prefix' => '/customer', 'middleware' => 'check-auth'], function (Router $router) {
    // to do
    $router->get('logout', ['as' => 'fe.customer.customer.logout', 'uses' => 'ProfileController@logout']);
    $router->get('api-management', ['as' => 'fe.customer.customer.apiManagement', 'uses' => 'ProfileController@getApiKeys']);
    $router->get('account', ['as' => 'fe.customer.customer.account', 'uses' => 'ProfileController@index']);
    $router->get('account/edit', ['as' => 'fe.customer.customer.account.edit', 'uses' => 'ProfileController@getProfileEdit']);
    $router->get('setting', ['as' => 'fe.customer.customer.setting', 'uses' => 'ProfileController@getSetting']);
    $router->get('affiliate', ['as' => 'fe.customer.customer.affiliate', 'uses' => 'ProfileController@affiliate']);
    $router->get('kyc', ['as' => 'fe.customer.customer.kyc', 'uses' => 'KycController@getKyc']);
    $router->post('requestKyc', ['as' => 'fe.customer.customer.requestKyc', 'uses' => 'KycApiController@requestKyc']);
    $router->post('updateKyc', ['as' => 'fe.customer.customer.updateKyc', 'uses' => 'KycApiController@updateKyc']);
    $router->get('getCurrentKyc', ['as' => 'fe.customer.customer.getCurrentKyc', 'uses' => 'KycApiController@getCurrentKyc']);
    $router->get('activities', ['as' => 'fe.customer.customer.activities', 'uses' => 'ProfileController@getActivities']);

    $router->post('account/edit', ['as' => 'fe.customer.customer.account.updateProfile', 'uses' => 'ProfileController@updateProfile']);

    $router->post('account/edit', ['as' => 'fe.customer.customer.account.updateProfile', 'uses' => 'ProfileController@updateProfile']);

    $router->post('account/send-code-change-password', ['as' => 'fe.customer.customer.account.sendCodeChangePassword', 'uses' => 'ChangePasswordController@sendCodeChangePassword']);
    $router->post('account/request-change-password', ['as' => 'fe.customer.customer.account.changePassword', 'uses' => 'ChangePasswordController@changePassword']);

    $router->get('payment-method/{paymentMethodID}/create', ['as' => 'fe.customer.payment.get.create', 'uses' => 'PaymentMethodController@index']);
});
$router->group(['prefix' => '/api/customer', 'middleware' => 'check-auth'], function (Router $router) {
  
    $router->get('payment-method/{paymentMethodId}', ['uses' => 'ApiPaymentMethodController@findPaymentMethod']);
    $router->get('list-my-payment-method', ['uses' => 'ApiPaymentMethodController@listMyPaymentMethod']);
    $router->get('find-my-payment-method/{paymentMethodcustomerId}', ['uses' => 'ApiPaymentMethodController@findMyPaymentMethod']);
    $router->post('submitPaymentMethod', ['uses' => 'ApiPaymentMethodController@submitPaymentMethod']);
    $router->post('updatePaymentMethod/{paymentMethodcustomerId}', ['uses' => 'ApiPaymentMethodController@updatePaymentMethod']);
});

$router->get('list-country', ['uses' => 'ApiPublicController@listCountry']);

$router->group(['prefix' => '/customer/api-management', 'middleware' => 'check-auth'], function (Router $router) {
    $router->post('create', [
        'as' => 'api.customer.apiKey.create',
        'uses' => 'ApiManagementController@create'
    ]);
    $router->delete('delete', [
        'as' => 'api.customer.apiKey.delete',
        'uses' => 'ApiManagementController@delete'
    ]);
});