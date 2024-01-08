<?php

namespace Modules\Customer\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Customer\Http\Middleware\CheckAuthCustomer;
use Modules\Customer\Http\Middleware\ApiKeyMiddleware;
use Modules\Customer\Listeners\RegisterCustomerSidebar;

class CustomerServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    protected $middleware = [
        'check-auth' => CheckAuthCustomer::class,
        'api-key' => ApiKeyMiddleware::class
    ];
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterCustomerSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('customers', Arr::dot(trans('customer::customers')));
            $event->load('customerkycs', Arr::dot(trans('customer::customerkycs')));
            $event->load('customercodes', Arr::dot(trans('customer::customercodes')));
            $event->load('paymentmethods', Arr::dot(trans('customer::paymentmethods')));
            $event->load('paymentmethodattrs', Arr::dot(trans('customer::paymentmethodattrs')));
            $event->load('paymentmethodcustomers', Arr::dot(trans('customer::paymentmethodcustomers')));
            $event->load('paymentmethodcustomerattrs', Arr::dot(trans('customer::paymentmethodcustomerattrs')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('customer', 'permissions');
        $this->registerMiddleware();
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
            'Modules\Customer\Repositories\CustomerApiKeyRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerApiKeyRepository(new \Modules\Customer\Entities\CustomerApiKey());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerApiKeyDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Customer\Repositories\CustomerRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerRepository(new \Modules\Customer\Entities\Customer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\CustomerProfileRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerProfileRepository(new \Modules\Customer\Entities\CustomerProfile());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerProfileDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\CustomerHistoryRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerHistoryRepository(new \Modules\Customer\Entities\CustomerHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerHistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\CustomerDeviceRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerDeviceRepository(new \Modules\Customer\Entities\CustomerDevice());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerDeviceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\CustomerSocialRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerSocialRepository(new \Modules\Customer\Entities\CustomerSocial());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerSocialDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\CustomerKycRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerKycRepository(new \Modules\Customer\Entities\CustomerKyc());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerKycDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\CountryRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCountryRepository(new \Modules\Customer\Entities\Country());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCountryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\CustomerCodeRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentCustomerCodeRepository(new \Modules\Customer\Entities\CustomerCode());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CacheCustomerCodeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\PaymentMethodRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentPaymentMethodRepository(new \Modules\Customer\Entities\PaymentMethod());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CachePaymentMethodDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\PaymentMethodAttrRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentPaymentMethodAttrRepository(new \Modules\Customer\Entities\PaymentMethodAttr());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CachePaymentMethodAttrDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\PaymentMethodCustomerRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentPaymentMethodCustomerRepository(new \Modules\Customer\Entities\PaymentMethodCustomer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CachePaymentMethodCustomerDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Customer\Repositories\PaymentMethodCustomerAttrRepository',
            function () {
                $repository = new \Modules\Customer\Repositories\Eloquent\EloquentPaymentMethodCustomerAttrRepository(new \Modules\Customer\Entities\PaymentMethodCustomerAttr());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Customer\Repositories\Cache\CachePaymentMethodCustomerAttrDecorator($repository);
            }
        );
// add bindings

    }


    private function registerMiddleware()
    {
        foreach ($this->middleware as $name => $class) {
            $this->app['router']->aliasMiddleware($name, $class);
        }
    }


}
