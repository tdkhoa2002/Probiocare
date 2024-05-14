<?php

namespace Modules\Wallet\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Wallet\Listeners\RegisterWalletSidebar;

class WalletServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerCommands();
        $this->app['events']->listen(BuildingSidebar::class, RegisterWalletSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('blockchains', Arr::dot(trans('wallet::blockchains')));
            $event->load('currencies', Arr::dot(trans('wallet::currencies')));
            $event->load('currencyattrs', Arr::dot(trans('wallet::currencyattrs')));
            $event->load('transactions', Arr::dot(trans('wallet::transactions')));
            $event->load('wallets', Arr::dot(trans('wallet::wallets')));
            $event->load('chainwallets', Arr::dot(trans('wallet::chainwallets')));
            $event->load('walletchains', Arr::dot(trans('wallet::walletchains')));
            $event->load('transactioncodes', Arr::dot(trans('wallet::transactioncodes')));
            $event->load('crawlhistories', Arr::dot(trans('wallet::crawlhistories')));
            $event->load('crawldeposits', Arr::dot(trans('wallet::crawldeposits')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('wallet', 'permissions');
        $this->publishConfig('wallet', 'settings');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerCommands()
    {
       
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Wallet\Repositories\BlockchainRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentBlockchainRepository(new \Modules\Wallet\Entities\Blockchain());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheBlockchainDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\CurrencyRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentCurrencyRepository(new \Modules\Wallet\Entities\Currency());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheCurrencyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\CurrencyAttrRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentCurrencyAttrRepository(new \Modules\Wallet\Entities\CurrencyAttr());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheCurrencyAttrDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\TransactionRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentTransactionRepository(new \Modules\Wallet\Entities\Transaction());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheTransactionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\WalletRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentWalletRepository(new \Modules\Wallet\Entities\Wallet());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheWalletDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\ChainWalletRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentChainWalletRepository(new \Modules\Wallet\Entities\ChainWallet());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheChainWalletDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\WalletChainRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentWalletChainRepository(new \Modules\Wallet\Entities\WalletChain());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheWalletChainDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\TransactionCodeRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentTransactionCodeRepository(new \Modules\Wallet\Entities\TransactionCode());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheTransactionCodeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\CrawlHistoryRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentCrawlHistoryRepository(new \Modules\Wallet\Entities\CrawlHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheCrawlHistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Wallet\Repositories\CrawlDepositRepository',
            function () {
                $repository = new \Modules\Wallet\Repositories\Eloquent\EloquentCrawlDepositRepository(new \Modules\Wallet\Entities\CrawlDeposit());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Wallet\Repositories\Cache\CacheCrawlDepositDecorator($repository);
            }
        );
// add bindings










    }


}
