<?php

namespace Modules\Loyalty\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Loyalty\Console\CalCommissionLoyalty;
use Modules\Loyalty\Console\CalRewardLoyalty;
use Modules\Loyalty\Listeners\RegisterLoyaltySidebar;

class LoyaltyServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterLoyaltySidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('packages', Arr::dot(trans('loyalty::packages')));
            $event->load('packageterms', Arr::dot(trans('loyalty::packageterms')));
            $event->load('commissions', Arr::dot(trans('loyalty::commissions')));
            $event->load('rewards', Arr::dot(trans('loyalty::rewards')));
            $event->load('orders', Arr::dot(trans('loyalty::orders')));
            // append translations





        });
    }

    public function boot()
    {
        $this->publishConfig('loyalty', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('cal:reward-loyalty')->hourly();
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
            'Modules\Loyalty\Repositories\PackageRepository',
            function () {
                $repository = new \Modules\Loyalty\Repositories\Eloquent\EloquentPackageRepository(new \Modules\Loyalty\Entities\Package());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Loyalty\Repositories\Cache\CachePackageDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Loyalty\Repositories\PackageTermRepository',
            function () {
                $repository = new \Modules\Loyalty\Repositories\Eloquent\EloquentPackageTermRepository(new \Modules\Loyalty\Entities\PackageTerm());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Loyalty\Repositories\Cache\CachePackageTermDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Loyalty\Repositories\CommissionRepository',
            function () {
                $repository = new \Modules\Loyalty\Repositories\Eloquent\EloquentCommissionRepository(new \Modules\Loyalty\Entities\Commission());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Loyalty\Repositories\Cache\CacheCommissionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Loyalty\Repositories\RewardRepository',
            function () {
                $repository = new \Modules\Loyalty\Repositories\Eloquent\EloquentRewardRepository(new \Modules\Loyalty\Entities\Reward());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Loyalty\Repositories\Cache\CacheRewardDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Loyalty\Repositories\OrderRepository',
            function () {
                $repository = new \Modules\Loyalty\Repositories\Eloquent\EloquentOrderRepository(new \Modules\Loyalty\Entities\Order());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Loyalty\Repositories\Cache\CacheOrderDecorator($repository);
            }
        );
// add bindings





    }

    private function registerCommands()
    {
        $this->commands([
            CalRewardLoyalty::class,
            CalCommissionLoyalty::class
        ]);
    }
}
