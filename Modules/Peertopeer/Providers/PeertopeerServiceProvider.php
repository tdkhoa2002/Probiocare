<?php

namespace Modules\Peertopeer\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Peertopeer\Console\TimeoutP2p;
use Modules\Peertopeer\Listeners\RegisterPeertopeerSidebar;

class PeertopeerServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterPeertopeerSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('ads', Arr::dot(trans('peertopeer::ads')));
            $event->load('orders', Arr::dot(trans('peertopeer::orders')));
            $event->load('orderhistories', Arr::dot(trans('peertopeer::orderhistories')));
            $event->load('chats', Arr::dot(trans('peertopeer::chats')));
            $event->load('adspaymentmethods', Arr::dot(trans('peertopeer::adspaymentmethods')));
            // append translations





        });
    }

    public function boot()
    {
        $this->publishConfig('peertopeer', 'permissions');
        $this->publishConfig('peertopeer', 'settings');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->commands([TimeoutP2p::class]);

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('cronjob:timeout-p2p')->everyMinute();
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
            'Modules\Peertopeer\Repositories\AdsRepository',
            function () {
                $repository = new \Modules\Peertopeer\Repositories\Eloquent\EloquentAdsRepository(new \Modules\Peertopeer\Entities\Ads());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Peertopeer\Repositories\Cache\CacheAdsDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Peertopeer\Repositories\OrderRepository',
            function () {
                $repository = new \Modules\Peertopeer\Repositories\Eloquent\EloquentOrderRepository(new \Modules\Peertopeer\Entities\Order());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Peertopeer\Repositories\Cache\CacheOrderDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Peertopeer\Repositories\OrderHistoryRepository',
            function () {
                $repository = new \Modules\Peertopeer\Repositories\Eloquent\EloquentOrderHistoryRepository(new \Modules\Peertopeer\Entities\OrderHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Peertopeer\Repositories\Cache\CacheOrderHistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Peertopeer\Repositories\ChatRepository',
            function () {
                $repository = new \Modules\Peertopeer\Repositories\Eloquent\EloquentChatRepository(new \Modules\Peertopeer\Entities\Chat());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Peertopeer\Repositories\Cache\CacheChatDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Peertopeer\Repositories\AdsPaymentMethodRepository',
            function () {
                $repository = new \Modules\Peertopeer\Repositories\Eloquent\EloquentAdsPaymentMethodRepository(new \Modules\Peertopeer\Entities\AdsPaymentMethod());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Peertopeer\Repositories\Cache\CacheAdsPaymentMethodDecorator($repository);
            }
        );
// add bindings





    }
}
