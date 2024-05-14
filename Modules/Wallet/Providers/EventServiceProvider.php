<?php

namespace Modules\Wallet\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Wallet\Events\CreateCrawlHistory;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\IncreaseBalanceWallet;
use Modules\Wallet\Events\ResetOnHoldWalletChain;
use Modules\Wallet\Events\UpdateBalanceOnHold;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Events\UpdateTotalCrawlDeposit;
use Modules\Wallet\Events\UpdateTransaction;
use Modules\Wallet\Listeners\CreateCrawlHistoryListener;
use Modules\Wallet\Listeners\CreateTransactionListener;
use Modules\Wallet\Listeners\IncreaseBalanceWalletListener;
use Modules\Wallet\Listeners\ResetOnHoldWalletChainListener;
use Modules\Wallet\Listeners\UpdateBalanceOnHoldListener;
use Modules\Wallet\Listeners\UpdateBalanceWalletListener;
use Modules\Wallet\Listeners\UpdateTotalCrawlDepositListener;
use Modules\Wallet\Listeners\UpdateTransactionListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UpdateBalanceWallet::class => [
            UpdateBalanceWalletListener::class
        ],
        CreateTransaction::class => [
            CreateTransactionListener::class
        ],
        UpdateTransaction::class => [
            UpdateTransactionListener::class
        ],
        IncreaseBalanceWallet::class => [
            IncreaseBalanceWalletListener::class
        ],
        UpdateBalanceOnHold::class => [
            UpdateBalanceOnHoldListener::class
        ],
        CreateCrawlHistory::class => [
            CreateCrawlHistoryListener::class
        ],
        ResetOnHoldWalletChain::class => [
            ResetOnHoldWalletChainListener::class
        ],
        UpdateTotalCrawlDeposit::class => [
            UpdateTotalCrawlDepositListener::class
        ]
    ];
}
