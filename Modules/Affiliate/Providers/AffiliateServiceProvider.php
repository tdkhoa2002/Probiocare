<?php

namespace Modules\Affiliate\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Affiliate\Listeners\RegisterAffiliateSidebar;

class AffiliateServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterAffiliateSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('affiliates', Arr::dot(trans('affiliate::affiliates')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('affiliate', 'permissions');

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
            'Modules\Affiliate\Repositories\AffiliateRepository',
            function () {
                $repository = new \Modules\Affiliate\Repositories\Eloquent\EloquentAffiliateRepository(new \Modules\Affiliate\Entities\Affiliate());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Affiliate\Repositories\Cache\CacheAffiliateDecorator($repository);
            }
        );
// add bindings

    }


}
