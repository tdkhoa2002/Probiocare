<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/wallet', 'middleware' => 'check-auth'], function (Router $router) {
    $router->get('/', [
        'as' => 'fe.wallet.wallet.list',
        'uses' => 'PublicController@index'
    ]);
    $router->get('/deposit', [
        'as' => 'fe.wallet.wallet.deposit',
        'uses' => 'PublicController@deposit'
    ]);
    $router->get('/withdraw', [
        'as' => 'fe.wallet.wallet.withdraw',
        'uses' => 'PublicController@withdraw'
    ]);
    $router->get('/history', [
        'as' => 'fe.wallet.wallet.history',
        'uses' => 'PublicController@history'
    ]);
    $router->get('/earn', [
        'as' => 'fe.wallet.wallet.earn',
        'uses' => 'PublicController@index'
    ]);
    $router->get('getBlockchainSupport/{currencyId}', [
        'as' => 'api.fe.wallet.currency.getBlockchainSupport',
        'uses' => 'PublicApiController@getBlockchainSupport'
    ]);
    $router->get('getAddress', [
        'as' => 'api.fe.wallet.currency.getAddress',
        'uses' => 'PublicApiController@getAddress'
    ]);
    $router->post('withdraw', [
        'as' => 'api.fe.wallet.currency.withdraw',
        'uses' => 'WithdrawApiController@withdraw'
    ]);
    $router->post('resend-verify-code-withdraw', [
        'as' => 'api.fe.wallet.currency.resendVerifyCodeWithdraw',
        'uses' => 'WithdrawApiController@resendVerifyCodeWithdraw'
    ]);
    $router->get('list-withdraw', [
        'as' => 'api.fe.wallet.currency.listWithdraw',
        'uses' => 'WithdrawApiController@listWithdraw'
    ]);

    $router->post('verifyWithdraw', [
        'as' => 'api.fe.wallet.currency.verifyWithdraw',
        'uses' => 'WithdrawApiController@verifyWithdraw'
    ]);
    $router->get('convert', [
        'as' => 'fe.wallet.wallet.convert',
        'uses' => 'SwapController@convert'
    ]);
});
$router->group(['prefix' => '/wallet'], function (Router $router) {
    $router->get('/currencies', ['uses' => 'PublicApiController@getCurrencies']);
    $router->get('/get-balance/{currencyId}', ['uses' => 'PublicApiController@getBalance'])->middleware('check-auth');
    $router->post('/convert', ['uses' => 'PublicApiController@swap'])->middleware('check-auth');
});
$router->group(['prefix' => '/transaction'], function (Router $router) {
    $router->get('get-recent-transaction', [
        'uses' => 'PublicApiController@getRecentTransaction'
    ]);
});

$router->group(['prefix' => '/webhook'], function (Router $router) {
    $router->post('/hook-deposit', [
        'as' => 'wh.wallet.deposit',
        'uses' => 'WebHookController@hookDeposit'
    ]);
    $router->post('/hook-withdraw', [
        'as' => 'wh.wallet.hookWithdraw',
        'uses' => 'WebHookController@hookWithdraw'
    ]);
});
