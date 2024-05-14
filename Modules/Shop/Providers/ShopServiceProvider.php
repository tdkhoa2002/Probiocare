<?php

namespace Modules\Shop\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Shop\Listeners\RegisterShopSidebar;

class ShopServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterShopSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('shops', Arr::dot(trans('shop::shops')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('shop', 'permissions');

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
            'Modules\Shop\Repositories\ShopRepository',
            function () {
                $repository = new \Modules\Shop\Repositories\Eloquent\EloquentShopRepository(new \Modules\Shop\Entities\Shop());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Shop\Repositories\Cache\CacheShopDecorator($repository);
            }
        );
// add bindings

    }


}
