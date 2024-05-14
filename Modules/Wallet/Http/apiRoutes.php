<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => '/wallet', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {

    $router->get('blockchains-all', [
        'as' => 'api.wallet.blockchain.all',
        'uses' => 'BlockchainController@all',
        'middleware' => 'token-can:wallet.blockchains.index',
    ]);
    $router->get('blockchains', [
        'as' => 'api.wallet.blockchain.indexServerSide',
        'uses' => 'BlockchainController@indexServerSide',
        'middleware' => 'token-can:wallet.blockchains.index',
    ]);
    $router->get('blockchains/{blockchainId}', [
        'as' => 'api.wallet.blockchain.find',
        'uses' => 'BlockchainController@find',
        'middleware' => 'token-can:wallet.blockchains.index',
    ]);

    $router->post('blockchains', [
        'as' => 'api.wallet.blockchain.store',
        'uses' => 'BlockchainController@store',
        'middleware' => 'token-can:wallet.blockchains.create',
    ]);
    $router->post('blockchains/{blockchain}', [
        'as' => 'api.wallet.blockchain.update',
        'uses' => 'BlockchainController@update',
        'middleware' => 'token-can:wallet.blockchains.edit',
    ]);
    $router->delete('blockchains/{blockchain}', [
        'as' => 'api.wallet.blockchain.destroy',
        'uses' => 'BlockchainController@destroy',
        'middleware' => 'token-can:wallet.blockchains.destroy',
    ]);

    $router->get('transactions', [
        'as' => 'api.wallet.transaction.indexServerSide',
        'uses' => 'TransactionController@indexServerSide',
        'middleware' => 'token-can:wallet.transactions.index',
    ]);
    $router->get('get-static-transaction', [
        'as' => 'api.wallet.transaction.getstatictransaction',
        'uses' => 'TransactionController@getStaticTransaction',
        'middleware' => 'token-can:wallet.transactions.index',
    ]);
    $router->get('transactions/{transactionId}', [
        'as' => 'api.wallet.transaction.find',
        'uses' => 'TransactionController@find',
        'middleware' => 'token-can:wallet.transactions.index',
    ]);

    $router->post('transactions', [
        'as' => 'api.wallet.transaction.store',
        'uses' => 'TransactionController@store',
        'middleware' => 'token-can:wallet.transactions.create',
    ]);
    $router->post('transactions/{transaction}', [
        'as' => 'api.wallet.transaction.update',
        'uses' => 'TransactionController@update',
        'middleware' => 'token-can:wallet.transactions.edit',
    ]);
    $router->delete('transactions/{transaction}', [
        'as' => 'api.wallet.transaction.destroy',
        'uses' => 'TransactionController@destroy',
        'middleware' => 'token-can:wallet.transactions.destroy',
    ]);
    $router->post('transactions/{transaction}', [
        'as' => 'api.wallet.transaction.resendWithdraw',
        'uses' => 'TransactionController@resendWithdraw',
        'middleware' => 'token-can:wallet.transactions.resendWithdraw',
    ]);
    $router->post('cancel-transaction/{transaction}', [
        'as' => 'api.wallet.transaction.cancelWithdraw',
        'uses' => 'TransactionController@cancelWithdraw',
        'middleware' => 'token-can:wallet.transactions.cancelWithdraw',
    ]);

    $router->get('chainwallets', [
        'as' => 'api.wallet.chainwallet.indexServerSide',
        'uses' => 'ChainWalletController@indexServerSide',
        'middleware' => 'token-can:wallet.chainwallets.index',
    ]);
    $router->get('chainwallets/{chainwalletId}', [
        'as' => 'api.wallet.chainwallet.find',
        'uses' => 'ChainWalletController@find',
        'middleware' => 'token-can:wallet.chainwallets.index',
    ]);

    $router->post('chainwallets', [
        'as' => 'api.wallet.chainwallet.store',
        'uses' => 'ChainWalletController@store',
        'middleware' => 'token-can:wallet.chainwallets.create',
    ]);
    $router->post('chainwallets/{chainwallet}', [
        'as' => 'api.wallet.chainwallet.update',
        'uses' => 'ChainWalletController@update',
        'middleware' => 'token-can:wallet.chainwallets.edit',
    ]);
    $router->delete('chainwallets/{chainwallet}', [
        'as' => 'api.wallet.chainwallet.destroy',
        'uses' => 'ChainWalletController@destroy',
        'middleware' => 'token-can:wallet.chainwallets.destroy',
    ]);

    $router->get('currencies-all', [
        'as' => 'api.wallet.currency.all',
        'uses' => 'CurrencyController@all',
        'middleware' => 'token-can:wallet.currencies.index',
    ]);

    $router->get('currencies', [
        'as' => 'api.wallet.currency.indexServerSide',
        'uses' => 'CurrencyController@indexServerSide',
        'middleware' => 'token-can:wallet.currencies.index',
    ]);
    $router->get('currencies/{currencyId}', [
        'as' => 'api.wallet.currency.find',
        'uses' => 'CurrencyController@find',
        'middleware' => 'token-can:wallet.currencies.index',
    ]);

    $router->post('currencies', [
        'as' => 'api.wallet.currency.store',
        'uses' => 'CurrencyController@store',
        'middleware' => 'token-can:wallet.currencies.create',
    ]);
    $router->post('currencies/{currency}', [
        'as' => 'api.wallet.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'token-can:wallet.currencies.edit',
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'api.wallet.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'token-can:wallet.currencies.destroy',
    ]);

    $router->get('currencyattrs/{currencyId}', [
        'as' => 'api.wallet.currencyattr.listByCurrency',
        'uses' => 'CurrencyAttrController@listByCurrency',
        'middleware' => 'token-can:wallet.currencyattrs.index',
    ]);
    $router->get('find-currencyattr/{currencyAttrId}', [
        'as' => 'api.wallet.currencyattr.find',
        'uses' => 'CurrencyAttrController@find',
        'middleware' => 'token-can:wallet.currencyattrs.index',
    ]);
    $router->post('currencyattrs/{currencyId}', [
        'as' => 'api.wallet.currencyattr.store',
        'uses' => 'CurrencyAttrController@store',
        'middleware' => 'token-can:wallet.currencyattrs.create',
    ]);
    $router->post('updatecurrencyattrs/{currencyId}/{currencyAttrId}', [
        'as' => 'api.wallet.currencyattr.update',
        'uses' => 'CurrencyAttrController@update',
        'middleware' => 'token-can:wallet.currencyattrs.edit',
    ]);
    $router->delete('currencyattrs/{currencyAttrId}', [
        'as' => 'api.wallet.currencyattr.destroy',
        'uses' => 'CurrencyAttrController@destroy',
        'middleware' => 'token-can:wallet.currencyattrs.destroy',
    ]);


    
    $router->get('wallets', [
        'as' => 'api.wallet.wallet.indexServerSide',
        'uses' => 'WalletController@indexServerSide',
        'middleware' => 'token-can:wallet.wallets.index',
    ]);
    $router->get('resyncAddress', [
        'as' => 'api.wallet.wallet.resyncAddress',
        'uses' => 'WalletController@resyncAddress',
        'middleware' => 'token-can:wallet.wallets.index',
    ]);
    $router->post('wallets', [
        'as' => 'api.wallet.wallet.store',
        'uses' => 'WalletController@store',
        'middleware' => 'token-can:wallet.wallets.create',
    ]);

    $router->get('crawlhistories', [
        'as' => 'api.wallet.crawlhistories.indexServerSide',
        'uses' => 'CrawlHistoryController@indexServerSide',
        'middleware' => 'token-can:wallet.crawlhistories.index',
    ]);
    $router->post('crawlhistories', [
        'as' => 'api.wallet.crawlhistories.crawl',
        'uses' => 'CrawlHistoryController@crawl',
        'middleware' => 'token-can:wallet.crawlhistories.crawl',
    ]);
});

$router->group(['prefix' => '/public/wallet'], function (Router $router) {
    $router->get('currencies', [
        'as' => 'api.fe.wallet.currency.list',
        'uses' => 'CurrencyController@getCurrencies'
    ]);
    $router->get('swap-currencies', [
        'uses' => 'CurrencyController@getCurrencySwap'
    ]);
    $router->get('swap-currencies-enable/{currencyId}', [
        'uses' => 'CurrencyController@getCurrencySwapEnable'
    ]);
    $router->get('detail-currency/{currencyId}', [
        'uses' => 'CurrencyController@detailCurrency'
    ]);
    $router->get('fiat-currencies', [
        'as' => 'api.fe.wallet.currency.listFiat',
        'uses' => 'CurrencyController@getFiatCurrencies'
    ]);
});


$router->group(['prefix' => '/price'], function (Router $router) {
    $router->get('/{symbol}', [
        'as' => 'api.price.currency.get',
        'uses' => 'CurrencyController@getCurrencyPrice'
    ]);
});
