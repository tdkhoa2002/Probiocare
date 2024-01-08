<?php

namespace Modules\Dynamicfield\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Dynamicfield\Entities\Field;
use Modules\Dynamicfield\Listeners\RegisterDynamicfieldSidebar;
use Modules\Dynamicfield\Repositories\Eloquent\EloquentFieldsRepository;

class DynamicfieldServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterDynamicfieldSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('dynamicfield', Arr::dot(trans('dynamicfield::dynamicfield')));
        });
    }

    public function boot()
    {
        $this->publishConfig('dynamicfield', 'permissions');

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
            'Modules\Dynamicfield\Repositories\FieldsRepository',
            function () {
                $repository = new \Modules\Dynamicfield\Repositories\Eloquent\EloquentFieldsRepository(new \Modules\Dynamicfield\Entities\Field());
                if (!config('app.cache')) {
                    return $repository;
                }
            }
        );

        $this->app->bind(
            'Modules\Dynamicfield\Repositories\GroupRepository',
            function () {
                $repository = new \Modules\Dynamicfield\Repositories\Eloquent\EloquentGroupRepository(new \Modules\Dynamicfield\Entities\Group());
                if (!config('app.cache')) {
                    return $repository;
                }
            }
        );

        $this->app->bind(
            'Modules\Dynamicfield\Repositories\GroupFieldRepository',
            function () {
                $repository = new \Modules\Dynamicfield\Repositories\Eloquent\EloquentGroupFieldRepository(new \Modules\Dynamicfield\Entities\Field());
                if (!config('app.cache')) {
                    return $repository;
                }
            }
        );
        // add bindings
    }
}
