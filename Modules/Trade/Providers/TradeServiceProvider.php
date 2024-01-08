<?php

namespace Modules\Trade\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Trade\Console\CreateHookTatum;
use Modules\Trade\Console\TestTatum;
use Modules\Trade\Listeners\RegisterTradeSidebar;
use Illuminate\Console\Scheduling\Schedule;

class TradeServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterTradeSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('markets', Arr::dot(trans('trade::markets')));
            $event->load('trades', Arr::dot(trans('trade::trades')));
            $event->load('chat', Arr::dot(trans('trade::trades')));
            $event->load('tradehistories', Arr::dot(trans('trade::tradehistories')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('trade', 'permissions');
        $this->publishConfig('trade', 'settings');
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

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Trade\Repositories\MarketRepository',
            function () {
                $repository = new \Modules\Trade\Repositories\Eloquent\EloquentMarketRepository(new \Modules\Trade\Entities\Market());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Trade\Repositories\Cache\CacheMarketDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Trade\Repositories\TradeRepository',
            function () {
                $repository = new \Modules\Trade\Repositories\Eloquent\EloquentTradeRepository(new \Modules\Trade\Entities\Trade());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Trade\Repositories\Cache\CacheTradeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Trade\Repositories\TradeHistoryRepository',
            function () {
                $repository = new \Modules\Trade\Repositories\Eloquent\EloquentTradeHistoryRepository(new \Modules\Trade\Entities\TradeHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Trade\Repositories\Cache\CacheTradeHistoryDecorator($repository);
            }
        );
// add bindings





    }

    private function registerCommands()
    {
        $this->commands([
            CreateHookTatum::class,
            TestTatum::class
        ]);
    }
}
