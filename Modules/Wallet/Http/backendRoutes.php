<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/wallet'], function (Router $router) {
    $router->bind('blockchain', function ($id) {
        return app('Modules\Wallet\Repositories\BlockchainRepository')->find($id);
    });
    $router->get('blockchains', [
        'as' => 'admin.wallet.blockchain.index',
        'uses' => 'BlockchainController@index',
        'middleware' => 'can:wallet.blockchains.index'
    ]);
    $router->get('blockchains/create', [
        'as' => 'admin.wallet.blockchain.create',
        'uses' => 'BlockchainController@create',
        'middleware' => 'can:wallet.blockchains.create'
    ]);
    $router->post('blockchains', [
        'as' => 'admin.wallet.blockchain.store',
        'uses' => 'BlockchainController@store',
        'middleware' => 'can:wallet.blockchains.create'
    ]);
    $router->get('blockchains/{blockchain}/edit', [
        'as' => 'admin.wallet.blockchain.edit',
        'uses' => 'BlockchainController@edit',
        'middleware' => 'can:wallet.blockchains.edit'
    ]);
    $router->put('blockchains/{blockchain}', [
        'as' => 'admin.wallet.blockchain.update',
        'uses' => 'BlockchainController@update',
        'middleware' => 'can:wallet.blockchains.edit'
    ]);
    $router->delete('blockchains/{blockchain}', [
        'as' => 'admin.wallet.blockchain.destroy',
        'uses' => 'BlockchainController@destroy',
        'middleware' => 'can:wallet.blockchains.destroy'
    ]);
    $router->bind('currency', function ($id) {
        return app('Modules\Wallet\Repositories\CurrencyRepository')->find($id);
    });
    $router->get('currencies', [
        'as' => 'admin.wallet.currency.index',
        'uses' => 'CurrencyController@index',
        'middleware' => 'can:wallet.currencies.index'
    ]);
    $router->get('currencies/create', [
        'as' => 'admin.wallet.currency.create',
        'uses' => 'CurrencyController@create',
        'middleware' => 'can:wallet.currencies.create'
    ]);
    $router->post('currencies', [
        'as' => 'admin.wallet.currency.store',
        'uses' => 'CurrencyController@store',
        'middleware' => 'can:wallet.currencies.create'
    ]);
    $router->get('currencies/{currency}/edit', [
        'as' => 'admin.wallet.currency.edit',
        'uses' => 'CurrencyController@edit',
        'middleware' => 'can:wallet.currencies.edit'
    ]);
    $router->put('currencies/{currency}', [
        'as' => 'admin.wallet.currency.update',
        'uses' => 'CurrencyController@update',
        'middleware' => 'can:wallet.currencies.edit'
    ]);
    $router->delete('currencies/{currency}', [
        'as' => 'admin.wallet.currency.destroy',
        'uses' => 'CurrencyController@destroy',
        'middleware' => 'can:wallet.currencies.destroy'
    ]);
    $router->bind('currencyattr', function ($id) {
        return app('Modules\Wallet\Repositories\CurrencyAttrRepository')->find($id);
    });
    $router->get('currencyattrs', [
        'as' => 'admin.wallet.currencyattr.index',
        'uses' => 'CurrencyAttrController@index',
        'middleware' => 'can:wallet.currencyattrs.index'
    ]);
    $router->get('currencyattrs/create', [
        'as' => 'admin.wallet.currencyattr.create',
        'uses' => 'CurrencyAttrController@create',
        'middleware' => 'can:wallet.currencyattrs.create'
    ]);
    $router->post('currencyattrs', [
        'as' => 'admin.wallet.currencyattr.store',
        'uses' => 'CurrencyAttrController@store',
        'middleware' => 'can:wallet.currencyattrs.create'
    ]);
    $router->get('currencyattrs/{currencyattr}/edit', [
        'as' => 'admin.wallet.currencyattr.edit',
        'uses' => 'CurrencyAttrController@edit',
        'middleware' => 'can:wallet.currencyattrs.edit'
    ]);
    $router->put('currencyattrs/{currencyattr}', [
        'as' => 'admin.wallet.currencyattr.update',
        'uses' => 'CurrencyAttrController@update',
        'middleware' => 'can:wallet.currencyattrs.edit'
    ]);
    $router->delete('currencyattrs/{currencyattr}', [
        'as' => 'admin.wallet.currencyattr.destroy',
        'uses' => 'CurrencyAttrController@destroy',
        'middleware' => 'can:wallet.currencyattrs.destroy'
    ]);
    $router->bind('transaction', function ($id) {
        return app('Modules\Wallet\Repositories\TransactionRepository')->find($id);
    });
    $router->get('transactions', [
        'as' => 'admin.wallet.transaction.index',
        'uses' => 'TransactionController@index',
        'middleware' => 'can:wallet.transactions.index'
    ]);
    $router->get('transactions/create', [
        'as' => 'admin.wallet.transaction.create',
        'uses' => 'TransactionController@create',
        'middleware' => 'can:wallet.transactions.create'
    ]);
    $router->post('transactions', [
        'as' => 'admin.wallet.transaction.store',
        'uses' => 'TransactionController@store',
        'middleware' => 'can:wallet.transactions.create'
    ]);
    $router->get('transactions/{transaction}/edit', [
        'as' => 'admin.wallet.transaction.edit',
        'uses' => 'TransactionController@edit',
        'middleware' => 'can:wallet.transactions.edit'
    ]);
    $router->put('transactions/{transaction}', [
        'as' => 'admin.wallet.transaction.update',
        'uses' => 'TransactionController@update',
        'middleware' => 'can:wallet.transactions.edit'
    ]);
    $router->delete('transactions/{transaction}', [
        'as' => 'admin.wallet.transaction.destroy',
        'uses' => 'TransactionController@destroy',
        'middleware' => 'can:wallet.transactions.destroy'
    ]);
    $router->bind('wallet', function ($id) {
        return app('Modules\Wallet\Repositories\WalletRepository')->find($id);
    });
    $router->get('wallets', [
        'as' => 'admin.wallet.wallet.index',
        'uses' => 'WalletController@index',
        'middleware' => 'can:wallet.wallets.index'
    ]);
    $router->get('wallets/create', [
        'as' => 'admin.wallet.wallet.create',
        'uses' => 'WalletController@create',
        'middleware' => 'can:wallet.wallets.create'
    ]);
    $router->post('wallets', [
        'as' => 'admin.wallet.wallet.store',
        'uses' => 'WalletController@store',
        'middleware' => 'can:wallet.wallets.create'
    ]);
    $router->get('wallets/{wallet}/edit', [
        'as' => 'admin.wallet.wallet.edit',
        'uses' => 'WalletController@edit',
        'middleware' => 'can:wallet.wallets.edit'
    ]);
    $router->put('wallets/{wallet}', [
        'as' => 'admin.wallet.wallet.update',
        'uses' => 'WalletController@update',
        'middleware' => 'can:wallet.wallets.edit'
    ]);
    $router->delete('wallets/{wallet}', [
        'as' => 'admin.wallet.wallet.destroy',
        'uses' => 'WalletController@destroy',
        'middleware' => 'can:wallet.wallets.destroy'
    ]);
    $router->bind('chainwallet', function ($id) {
        return app('Modules\Wallet\Repositories\ChainWalletRepository')->find($id);
    });
    $router->get('chainwallets', [
        'as' => 'admin.wallet.chainwallet.index',
        'uses' => 'ChainWalletController@index',
        'middleware' => 'can:wallet.chainwallets.index'
    ]);
    $router->get('chainwallets/create', [
        'as' => 'admin.wallet.chainwallet.create',
        'uses' => 'ChainWalletController@create',
        'middleware' => 'can:wallet.chainwallets.create'
    ]);
    $router->post('chainwallets', [
        'as' => 'admin.wallet.chainwallet.store',
        'uses' => 'ChainWalletController@store',
        'middleware' => 'can:wallet.chainwallets.create'
    ]);
    $router->get('chainwallets/{chainwallet}/edit', [
        'as' => 'admin.wallet.chainwallet.edit',
        'uses' => 'ChainWalletController@edit',
        'middleware' => 'can:wallet.chainwallets.edit'
    ]);
    $router->put('chainwallets/{chainwallet}', [
        'as' => 'admin.wallet.chainwallet.update',
        'uses' => 'ChainWalletController@update',
        'middleware' => 'can:wallet.chainwallets.edit'
    ]);
    $router->delete('chainwallets/{chainwallet}', [
        'as' => 'admin.wallet.chainwallet.destroy',
        'uses' => 'ChainWalletController@destroy',
        'middleware' => 'can:wallet.chainwallets.destroy'
    ]);
    $router->bind('walletchain', function ($id) {
        return app('Modules\Wallet\Repositories\WalletChainRepository')->find($id);
    });
    $router->get('walletchains', [
        'as' => 'admin.wallet.walletchain.index',
        'uses' => 'WalletChainController@index',
        'middleware' => 'can:wallet.walletchains.index'
    ]);
    $router->get('walletchains/create', [
        'as' => 'admin.wallet.walletchain.create',
        'uses' => 'WalletChainController@create',
        'middleware' => 'can:wallet.walletchains.create'
    ]);
    $router->post('walletchains', [
        'as' => 'admin.wallet.walletchain.store',
        'uses' => 'WalletChainController@store',
        'middleware' => 'can:wallet.walletchains.create'
    ]);
    $router->get('walletchains/{walletchain}/edit', [
        'as' => 'admin.wallet.walletchain.edit',
        'uses' => 'WalletChainController@edit',
        'middleware' => 'can:wallet.walletchains.edit'
    ]);
    $router->put('walletchains/{walletchain}', [
        'as' => 'admin.wallet.walletchain.update',
        'uses' => 'WalletChainController@update',
        'middleware' => 'can:wallet.walletchains.edit'
    ]);
    $router->delete('walletchains/{walletchain}', [
        'as' => 'admin.wallet.walletchain.destroy',
        'uses' => 'WalletChainController@destroy',
        'middleware' => 'can:wallet.walletchains.destroy'
    ]);
    $router->bind('transactioncode', function ($id) {
        return app('Modules\Wallet\Repositories\TransactionCodeRepository')->find($id);
    });
    $router->get('transactioncodes', [
        'as' => 'admin.wallet.transactioncode.index',
        'uses' => 'TransactionCodeController@index',
        'middleware' => 'can:wallet.transactioncodes.index'
    ]);
    $router->get('transactioncodes/create', [
        'as' => 'admin.wallet.transactioncode.create',
        'uses' => 'TransactionCodeController@create',
        'middleware' => 'can:wallet.transactioncodes.create'
    ]);
    $router->post('transactioncodes', [
        'as' => 'admin.wallet.transactioncode.store',
        'uses' => 'TransactionCodeController@store',
        'middleware' => 'can:wallet.transactioncodes.create'
    ]);
    $router->get('transactioncodes/{transactioncode}/edit', [
        'as' => 'admin.wallet.transactioncode.edit',
        'uses' => 'TransactionCodeController@edit',
        'middleware' => 'can:wallet.transactioncodes.edit'
    ]);
    $router->put('transactioncodes/{transactioncode}', [
        'as' => 'admin.wallet.transactioncode.update',
        'uses' => 'TransactionCodeController@update',
        'middleware' => 'can:wallet.transactioncodes.edit'
    ]);
    $router->delete('transactioncodes/{transactioncode}', [
        'as' => 'admin.wallet.transactioncode.destroy',
        'uses' => 'TransactionCodeController@destroy',
        'middleware' => 'can:wallet.transactioncodes.destroy'
    ]);
   
    $router->get('crawlhistories', [
        'as' => 'admin.wallet.crawlhistory.index',
        'uses' => 'CrawlHistoryController@index',
        'middleware' => 'can:wallet.crawlhistories.index'
    ]);
// append










});
