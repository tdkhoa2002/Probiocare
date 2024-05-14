<?php

namespace Modules\ShoppingCart\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\ShoppingCart\Listeners\RegisterShoppingCartSidebar;
use Illuminate\Auth\Events\Logout;
use Illuminate\Session\SessionManager;

class ShoppingCartServiceProvider extends ServiceProvider
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
        $this->app->bind('cart', 'Modules\ShoppingCart\Cart');
        $this->app['events']->listen(BuildingSidebar::class, RegisterShoppingCartSidebar::class);
        $this->app['events']->listen(Logout::class, function () {
            if ($this->app['config']->get('cart.destroy_on_logout')) {
                $this->app->make(SessionManager::class)->forget('cart');
            }
        });
        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('orders', Arr::dot(trans('shoppingcart::orders')));
            $event->load('orderdetails',  Arr::dot(trans('shoppingcart::orderdetails')));
            // append translations


        });


    }

    public function boot()
    {
        $this->publishConfig('shoppingCart', 'permissions');
        $this->publishConfig('shoppingCart', 'config');
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
            'Modules\ShoppingCart\Repositories\OrderRepository',
            function () {
                $repository = new \Modules\ShoppingCart\Repositories\Eloquent\EloquentOrderRepository(new \Modules\ShoppingCart\Entities\Order());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\ShoppingCart\Repositories\Cache\CacheOrderDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\ShoppingCart\Repositories\OrderDetailRepository',
            function () {
                $repository = new \Modules\ShoppingCart\Repositories\Eloquent\EloquentOrderDetailRepository(new \Modules\ShoppingCart\Entities\OrderDetail());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\ShoppingCart\Repositories\Cache\CacheOrderDetailDecorator($repository);
            }
        );
// add bindings


    }


}
