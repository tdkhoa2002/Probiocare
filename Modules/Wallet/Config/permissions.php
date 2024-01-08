<?php

return [
    'wallet.blockchains' => [
        'index' => 'wallet::blockchains.list resource',
        'create' => 'wallet::blockchains.create resource',
        'edit' => 'wallet::blockchains.edit resource',
        'destroy' => 'wallet::blockchains.destroy resource',
    ],
    'wallet.currencies' => [
        'index' => 'wallet::currencies.list resource',
        'create' => 'wallet::currencies.create resource',
        'edit' => 'wallet::currencies.edit resource',
        'destroy' => 'wallet::currencies.destroy resource',
    ],
    'wallet.currencyattrs' => [
        'index' => 'wallet::currencyattrs.list resource',
        'create' => 'wallet::currencyattrs.create resource',
        'edit' => 'wallet::currencyattrs.edit resource',
        'destroy' => 'wallet::currencyattrs.destroy resource',
    ],
    'wallet.transactions' => [
        'index' => 'wallet::transactions.list resource',
        'create' => 'wallet::transactions.create resource',
        'edit' => 'wallet::transactions.edit resource',
        'destroy' => 'wallet::transactions.destroy resource',
        'resendWithdraw' => 'wallet::transactions.resendWithdraw',
    ],
    'wallet.wallets' => [
        'index' => 'wallet::wallets.list resource',
        'create' => 'wallet::wallets.create resource',
        'edit' => 'wallet::wallets.edit resource',
        'destroy' => 'wallet::wallets.destroy resource',
    ],
    'wallet.chainwallets' => [
        'index' => 'wallet::chainwallets.list resource',
        'create' => 'wallet::chainwallets.create resource',
        'edit' => 'wallet::chainwallets.edit resource',
        'destroy' => 'wallet::chainwallets.destroy resource',
    ],
    'wallet.walletchains' => [
        'index' => 'wallet::walletchains.list resource',
        'create' => 'wallet::walletchains.create resource',
        'edit' => 'wallet::walletchains.edit resource',
        'destroy' => 'wallet::walletchains.destroy resource',
    ],
    'wallet.transactioncodes' => [
        'index' => 'wallet::transactioncodes.list resource',
        'create' => 'wallet::transactioncodes.create resource',
        'edit' => 'wallet::transactioncodes.edit resource',
        'destroy' => 'wallet::transactioncodes.destroy resource',
    ],
    'wallet.crawlhistories' => [
        'index' => 'wallet::crawlhistories.list resource',
        'crawl' => 'wallet::crawlhistories.crawl',
    ],
// append










];
