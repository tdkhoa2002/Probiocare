<?php

namespace Modules\Loyalty\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterLoyaltySidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('packages', Arr::dot(trans('loyalty::packages')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('loyalty', 'permissions');

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
            'Modules\Loyalty\Repositories\PackageRepository',
            function () {
                $repository = new \Modules\Loyalty\Repositories\Eloquent\EloquentPackageRepository(new \Modules\Loyalty\Entities\Package());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Loyalty\Repositories\Cache\CachePackageDecorator($repository);
            }
        );
// add bindings

    }


}
