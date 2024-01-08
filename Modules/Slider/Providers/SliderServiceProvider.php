<?php

namespace Modules\Slider\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Slider\Listeners\RegisterSliderSidebar;

class SliderServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration,CanGetSidebarClassForModule;
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterSliderSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('slides', Arr::dot(trans('slider::slides')));
            $event->load('sliders', Arr::dot(trans('slider::sliders')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('slider', 'permissions');
        $this->registerSliders();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('sliders');
    }

    private function registerSliders()
    {
        if (!$this->app['asgard.isInstalled']) {
            return;
        }
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Slider\Repositories\SlideRepository',
            function () {
                $repository = new \Modules\Slider\Repositories\Eloquent\EloquentSlideRepository(new \Modules\Slider\Entities\Slide());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Slider\Repositories\Cache\CacheSlideDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Slider\Repositories\SliderRepository',
            function () {
                $repository = new \Modules\Slider\Repositories\Eloquent\EloquentSliderRepository(new \Modules\Slider\Entities\Slider());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Slider\Repositories\Cache\CacheSliderDecorator($repository);
            }
        );
        $this->app->bind('Modules\Slider\Presenters\SliderPresenter');
// add bindings


    }


}
