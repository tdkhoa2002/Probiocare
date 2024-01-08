<?php

namespace Modules\MarketMaker\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\MarketMaker\Listeners\RegisterMarketMakerSidebar;
use Modules\MarketMaker\Console\TargetPrice;
use Modules\MarketMaker\Console\Volumnizer;
use Illuminate\Console\Scheduling\Schedule;

class MarketMakerServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterMarketMakerSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('targetprices', Arr::dot(trans('marketmaker::targetprices')));
            $event->load('volumnizers', Arr::dot(trans('marketmaker::volumnizers')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('marketMaker', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->commands([TargetPrice::class]);
        $this->commands([Volumnizer::class]);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('target:price')->everyMinute();
            $schedule->command('make:volumnizer')->everyMinute();
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
            'Modules\MarketMaker\Repositories\TargetPriceRepository',
            function () {
                $repository = new \Modules\MarketMaker\Repositories\Eloquent\EloquentTargetPriceRepository(new \Modules\MarketMaker\Entities\TargetPrice());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\MarketMaker\Repositories\Cache\CacheTargetPriceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\MarketMaker\Repositories\VolumnizerRepository',
            function () {
                $repository = new \Modules\MarketMaker\Repositories\Eloquent\EloquentVolumnizerRepository(new \Modules\MarketMaker\Entities\Volumnizer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\MarketMaker\Repositories\Cache\CacheVolumnizerDecorator($repository);
            }
        );
// add bindings


    }


}
