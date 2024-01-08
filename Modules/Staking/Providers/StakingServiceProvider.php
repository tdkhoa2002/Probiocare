<?php

namespace Modules\Staking\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Staking\Console\CalCommissionStake;
use Modules\Staking\Console\CalRewardStake;
use Modules\Staking\Listeners\RegisterStakingSidebar;

class StakingServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterStakingSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('packages', Arr::dot(trans('staking::packages')));
            $event->load('packageterms', Arr::dot(trans('staking::packageterms')));
            $event->load('commissions', Arr::dot(trans('staking::commissions')));
            $event->load('rewards', Arr::dot(trans('staking::rewards')));
            $event->load('orders', Arr::dot(trans('staking::orders')));
            // append translations





        });
    }

    public function boot()
    {
        $this->publishConfig('staking', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('cal:reward-stake')->hourly();
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
            'Modules\Staking\Repositories\PackageRepository',
            function () {
                $repository = new \Modules\Staking\Repositories\Eloquent\EloquentPackageRepository(new \Modules\Staking\Entities\Package());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Staking\Repositories\Cache\CachePackageDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Staking\Repositories\PackageTermRepository',
            function () {
                $repository = new \Modules\Staking\Repositories\Eloquent\EloquentPackageTermRepository(new \Modules\Staking\Entities\PackageTerm());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Staking\Repositories\Cache\CachePackageTermDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Staking\Repositories\CommissionRepository',
            function () {
                $repository = new \Modules\Staking\Repositories\Eloquent\EloquentCommissionRepository(new \Modules\Staking\Entities\Commission());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Staking\Repositories\Cache\CacheCommissionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Staking\Repositories\RewardRepository',
            function () {
                $repository = new \Modules\Staking\Repositories\Eloquent\EloquentRewardRepository(new \Modules\Staking\Entities\Reward());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Staking\Repositories\Cache\CacheRewardDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Staking\Repositories\OrderRepository',
            function () {
                $repository = new \Modules\Staking\Repositories\Eloquent\EloquentOrderRepository(new \Modules\Staking\Entities\Order());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Staking\Repositories\Cache\CacheOrderDecorator($repository);
            }
        );
        // add bindings





    }

    private function registerCommands()
    {
        $this->commands([
            CalRewardStake::class,
            CalCommissionStake::class
        ]);
    }
}
