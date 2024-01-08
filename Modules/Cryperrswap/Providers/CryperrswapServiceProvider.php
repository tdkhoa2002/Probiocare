<?php

namespace Modules\Cryperrswap\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Cryperrswap\Console\GetDetailOrder;
use Modules\Cryperrswap\Console\TestFixedFloar;
use Modules\Cryperrswap\Listeners\RegisterCryperrswapSidebar;

class CryperrswapServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterCryperrswapSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('services', Arr::dot(trans('cryperrswap::services')));
            $event->load('currencies', Arr::dot(trans('cryperrswap::currencies')));
            $event->load('orders', Arr::dot(trans('cryperrswap::orders')));
            // append translations



        });
    }

    public function boot()
    {
        $this->publishConfig('cryperrswap', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->commands([TestFixedFloar::class, GetDetailOrder::class]);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('get-detail:order')->everyMinute();
        });
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
            'Modules\Cryperrswap\Repositories\ServiceRepository',
            function () {
                $repository = new \Modules\Cryperrswap\Repositories\Eloquent\EloquentServiceRepository(new \Modules\Cryperrswap\Entities\Service());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Cryperrswap\Repositories\Cache\CacheServiceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Cryperrswap\Repositories\CurrencyRepository',
            function () {
                $repository = new \Modules\Cryperrswap\Repositories\Eloquent\EloquentCurrencyRepository(new \Modules\Cryperrswap\Entities\Currency());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Cryperrswap\Repositories\Cache\CacheCurrencyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Cryperrswap\Repositories\OrderRepository',
            function () {
                $repository = new \Modules\Cryperrswap\Repositories\Eloquent\EloquentOrderRepository(new \Modules\Cryperrswap\Entities\Order());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Cryperrswap\Repositories\Cache\CacheOrderDecorator($repository);
            }
        );
        // add bindings



    }
}
