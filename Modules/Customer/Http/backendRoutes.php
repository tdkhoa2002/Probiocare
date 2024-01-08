<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/customer'], function (Router $router) {
    $router->bind('customer', function ($id) {
        return app('Modules\Customer\Repositories\CustomerRepository')->find($id);
    });
    $router->get('customers', [
        'as' => 'admin.customer.customer.index',
        'uses' => 'CustomerController@index',
        'middleware' => 'can:customer.customers.index'
    ]);
    $router->get('customers/create', [
        'as' => 'admin.customer.customer.create',
        'uses' => 'CustomerController@create',
        'middleware' => 'can:customer.customers.create'
    ]);
    $router->post('customers', [
        'as' => 'admin.customer.customer.store',
        'uses' => 'CustomerController@store',
        'middleware' => 'can:customer.customers.create'
    ]);
    $router->get('customers/{customer}/edit', [
        'as' => 'admin.customer.customer.edit',
        'uses' => 'CustomerController@edit',
        'middleware' => 'can:customer.customers.edit'
    ]);
    $router->put('customers/{customer}', [
        'as' => 'admin.customer.customer.update',
        'uses' => 'CustomerController@update',
        'middleware' => 'can:customer.customers.edit'
    ]);
    $router->delete('customers/{customer}', [
        'as' => 'admin.customer.customer.destroy',
        'uses' => 'CustomerController@destroy',
        'middleware' => 'can:customer.customers.destroy'
    ]);
    $router->bind('customerprofile', function ($id) {
        return app('Modules\Customer\Repositories\CustomerProfileRepository')->find($id);
    });
    $router->get('customerprofiles', [
        'as' => 'admin.customer.customerprofile.index',
        'uses' => 'CustomerProfileController@index',
        'middleware' => 'can:customer.customerprofiles.index'
    ]);
    $router->get('customerprofiles/create', [
        'as' => 'admin.customer.customerprofile.create',
        'uses' => 'CustomerProfileController@create',
        'middleware' => 'can:customer.customerprofiles.create'
    ]);
    $router->post('customerprofiles', [
        'as' => 'admin.customer.customerprofile.store',
        'uses' => 'CustomerProfileController@store',
        'middleware' => 'can:customer.customerprofiles.create'
    ]);
    $router->get('customerprofiles/{customerprofile}/edit', [
        'as' => 'admin.customer.customerprofile.edit',
        'uses' => 'CustomerProfileController@edit',
        'middleware' => 'can:customer.customerprofiles.edit'
    ]);
    $router->put('customerprofiles/{customerprofile}', [
        'as' => 'admin.customer.customerprofile.update',
        'uses' => 'CustomerProfileController@update',
        'middleware' => 'can:customer.customerprofiles.edit'
    ]);
    $router->delete('customerprofiles/{customerprofile}', [
        'as' => 'admin.customer.customerprofile.destroy',
        'uses' => 'CustomerProfileController@destroy',
        'middleware' => 'can:customer.customerprofiles.destroy'
    ]);
    $router->bind('customerhistory', function ($id) {
        return app('Modules\Customer\Repositories\CustomerHistoryRepository')->find($id);
    });
    $router->get('customerhistories', [
        'as' => 'admin.customer.customerhistory.index',
        'uses' => 'CustomerHistoryController@index',
        'middleware' => 'can:customer.customerhistories.index'
    ]);
    $router->get('customerhistories/create', [
        'as' => 'admin.customer.customerhistory.create',
        'uses' => 'CustomerHistoryController@create',
        'middleware' => 'can:customer.customerhistories.create'
    ]);
    $router->post('customerhistories', [
        'as' => 'admin.customer.customerhistory.store',
        'uses' => 'CustomerHistoryController@store',
        'middleware' => 'can:customer.customerhistories.create'
    ]);
    $router->get('customerhistories/{customerhistory}/edit', [
        'as' => 'admin.customer.customerhistory.edit',
        'uses' => 'CustomerHistoryController@edit',
        'middleware' => 'can:customer.customerhistories.edit'
    ]);
    $router->put('customerhistories/{customerhistory}', [
        'as' => 'admin.customer.customerhistory.update',
        'uses' => 'CustomerHistoryController@update',
        'middleware' => 'can:customer.customerhistories.edit'
    ]);
    $router->delete('customerhistories/{customerhistory}', [
        'as' => 'admin.customer.customerhistory.destroy',
        'uses' => 'CustomerHistoryController@destroy',
        'middleware' => 'can:customer.customerhistories.destroy'
    ]);
    $router->bind('customerdevice', function ($id) {
        return app('Modules\Customer\Repositories\CustomerDeviceRepository')->find($id);
    });
    $router->get('customerdevices', [
        'as' => 'admin.customer.customerdevice.index',
        'uses' => 'CustomerDeviceController@index',
        'middleware' => 'can:customer.customerdevices.index'
    ]);
    $router->get('customerdevices/create', [
        'as' => 'admin.customer.customerdevice.create',
        'uses' => 'CustomerDeviceController@create',
        'middleware' => 'can:customer.customerdevices.create'
    ]);
    $router->post('customerdevices', [
        'as' => 'admin.customer.customerdevice.store',
        'uses' => 'CustomerDeviceController@store',
        'middleware' => 'can:customer.customerdevices.create'
    ]);
    $router->get('customerdevices/{customerdevice}/edit', [
        'as' => 'admin.customer.customerdevice.edit',
        'uses' => 'CustomerDeviceController@edit',
        'middleware' => 'can:customer.customerdevices.edit'
    ]);
    $router->put('customerdevices/{customerdevice}', [
        'as' => 'admin.customer.customerdevice.update',
        'uses' => 'CustomerDeviceController@update',
        'middleware' => 'can:customer.customerdevices.edit'
    ]);
    $router->delete('customerdevices/{customerdevice}', [
        'as' => 'admin.customer.customerdevice.destroy',
        'uses' => 'CustomerDeviceController@destroy',
        'middleware' => 'can:customer.customerdevices.destroy'
    ]);
    $router->bind('customersocial', function ($id) {
        return app('Modules\Customer\Repositories\CustomerSocialRepository')->find($id);
    });
    $router->get('customersocials', [
        'as' => 'admin.customer.customersocial.index',
        'uses' => 'CustomerSocialController@index',
        'middleware' => 'can:customer.customersocials.index'
    ]);
    $router->get('customersocials/create', [
        'as' => 'admin.customer.customersocial.create',
        'uses' => 'CustomerSocialController@create',
        'middleware' => 'can:customer.customersocials.create'
    ]);
    $router->post('customersocials', [
        'as' => 'admin.customer.customersocial.store',
        'uses' => 'CustomerSocialController@store',
        'middleware' => 'can:customer.customersocials.create'
    ]);
    $router->get('customersocials/{customersocial}/edit', [
        'as' => 'admin.customer.customersocial.edit',
        'uses' => 'CustomerSocialController@edit',
        'middleware' => 'can:customer.customersocials.edit'
    ]);
    $router->put('customersocials/{customersocial}', [
        'as' => 'admin.customer.customersocial.update',
        'uses' => 'CustomerSocialController@update',
        'middleware' => 'can:customer.customersocials.edit'
    ]);
    $router->delete('customersocials/{customersocial}', [
        'as' => 'admin.customer.customersocial.destroy',
        'uses' => 'CustomerSocialController@destroy',
        'middleware' => 'can:customer.customersocials.destroy'
    ]);
    $router->bind('customerkyc', function ($id) {
        return app('Modules\Customer\Repositories\CustomerKycRepository')->find($id);
    });
    $router->get('customerkycs', [
        'as' => 'admin.customer.customerkyc.index',
        'uses' => 'CustomerKycController@index',
        'middleware' => 'can:customer.customerkycs.index'
    ]);
    $router->get('customerkycs/create', [
        'as' => 'admin.customer.customerkyc.create',
        'uses' => 'CustomerKycController@create',
        'middleware' => 'can:customer.customerkycs.create'
    ]);
    $router->post('customerkycs', [
        'as' => 'admin.customer.customerkyc.store',
        'uses' => 'CustomerKycController@store',
        'middleware' => 'can:customer.customerkycs.create'
    ]);
    $router->get('customerkycs/{customerkyc}/edit', [
        'as' => 'admin.customer.customerkyc.edit',
        'uses' => 'CustomerKycController@edit',
        'middleware' => 'can:customer.customerkycs.edit'
    ]);
    $router->put('customerkycs/{customerkyc}', [
        'as' => 'admin.customer.customerkyc.update',
        'uses' => 'CustomerKycController@update',
        'middleware' => 'can:customer.customerkycs.edit'
    ]);
    $router->delete('customerkycs/{customerkyc}', [
        'as' => 'admin.customer.customerkyc.destroy',
        'uses' => 'CustomerKycController@destroy',
        'middleware' => 'can:customer.customerkycs.destroy'
    ]);
    $router->bind('country', function ($id) {
        return app('Modules\Customer\Repositories\CountryRepository')->find($id);
    });
    $router->get('countries', [
        'as' => 'admin.customer.country.index',
        'uses' => 'CountryController@index',
        'middleware' => 'can:customer.countries.index'
    ]);
    $router->get('countries/create', [
        'as' => 'admin.customer.country.create',
        'uses' => 'CountryController@create',
        'middleware' => 'can:customer.countries.create'
    ]);
    $router->post('countries', [
        'as' => 'admin.customer.country.store',
        'uses' => 'CountryController@store',
        'middleware' => 'can:customer.countries.create'
    ]);
    $router->get('countries/{country}/edit', [
        'as' => 'admin.customer.country.edit',
        'uses' => 'CountryController@edit',
        'middleware' => 'can:customer.countries.edit'
    ]);
    $router->put('countries/{country}', [
        'as' => 'admin.customer.country.update',
        'uses' => 'CountryController@update',
        'middleware' => 'can:customer.countries.edit'
    ]);
    $router->delete('countries/{country}', [
        'as' => 'admin.customer.country.destroy',
        'uses' => 'CountryController@destroy',
        'middleware' => 'can:customer.countries.destroy'
    ]);
    $router->bind('customercode', function ($id) {
        return app('Modules\Customer\Repositories\CustomerCodeRepository')->find($id);
    });
    $router->get('customercodes', [
        'as' => 'admin.customer.customercode.index',
        'uses' => 'CustomerCodeController@index',
        'middleware' => 'can:customer.customercodes.index'
    ]);
    $router->get('customercodes/create', [
        'as' => 'admin.customer.customercode.create',
        'uses' => 'CustomerCodeController@create',
        'middleware' => 'can:customer.customercodes.create'
    ]);
    $router->post('customercodes', [
        'as' => 'admin.customer.customercode.store',
        'uses' => 'CustomerCodeController@store',
        'middleware' => 'can:customer.customercodes.create'
    ]);
    $router->get('customercodes/{customercode}/edit', [
        'as' => 'admin.customer.customercode.edit',
        'uses' => 'CustomerCodeController@edit',
        'middleware' => 'can:customer.customercodes.edit'
    ]);
    $router->put('customercodes/{customercode}', [
        'as' => 'admin.customer.customercode.update',
        'uses' => 'CustomerCodeController@update',
        'middleware' => 'can:customer.customercodes.edit'
    ]);
    $router->delete('customercodes/{customercode}', [
        'as' => 'admin.customer.customercode.destroy',
        'uses' => 'CustomerCodeController@destroy',
        'middleware' => 'can:customer.customercodes.destroy'
    ]);
    $router->bind('paymentmethod', function ($id) {
        return app('Modules\Customer\Repositories\PaymentMethodRepository')->find($id);
    });
    $router->get('paymentmethods', [
        'as' => 'admin.customer.paymentmethod.index',
        'uses' => 'PaymentMethodController@index',
        'middleware' => 'can:customer.paymentmethods.index'
    ]);
    $router->get('paymentmethods/create', [
        'as' => 'admin.customer.paymentmethod.create',
        'uses' => 'PaymentMethodController@create',
        'middleware' => 'can:customer.paymentmethods.create'
    ]);
    $router->post('paymentmethods', [
        'as' => 'admin.customer.paymentmethod.store',
        'uses' => 'PaymentMethodController@store',
        'middleware' => 'can:customer.paymentmethods.create'
    ]);
    $router->get('paymentmethods/{paymentmethod}/edit', [
        'as' => 'admin.customer.paymentmethod.edit',
        'uses' => 'PaymentMethodController@edit',
        'middleware' => 'can:customer.paymentmethods.edit'
    ]);
    $router->put('paymentmethods/{paymentmethod}', [
        'as' => 'admin.customer.paymentmethod.update',
        'uses' => 'PaymentMethodController@update',
        'middleware' => 'can:customer.paymentmethods.edit'
    ]);
    $router->delete('paymentmethods/{paymentmethod}', [
        'as' => 'admin.customer.paymentmethod.destroy',
        'uses' => 'PaymentMethodController@destroy',
        'middleware' => 'can:customer.paymentmethods.destroy'
    ]);
    $router->bind('paymentmethodattr', function ($id) {
        return app('Modules\Customer\Repositories\PaymentMethodAttrRepository')->find($id);
    });
    $router->get('paymentmethodattrs', [
        'as' => 'admin.customer.paymentmethodattr.index',
        'uses' => 'PaymentMethodAttrController@index',
        'middleware' => 'can:customer.paymentmethodattrs.index'
    ]);
    $router->get('paymentmethodattrs/create', [
        'as' => 'admin.customer.paymentmethodattr.create',
        'uses' => 'PaymentMethodAttrController@create',
        'middleware' => 'can:customer.paymentmethodattrs.create'
    ]);
    $router->post('paymentmethodattrs', [
        'as' => 'admin.customer.paymentmethodattr.store',
        'uses' => 'PaymentMethodAttrController@store',
        'middleware' => 'can:customer.paymentmethodattrs.create'
    ]);
    $router->get('paymentmethodattrs/{paymentmethodattr}/edit', [
        'as' => 'admin.customer.paymentmethodattr.edit',
        'uses' => 'PaymentMethodAttrController@edit',
        'middleware' => 'can:customer.paymentmethodattrs.edit'
    ]);
    $router->put('paymentmethodattrs/{paymentmethodattr}', [
        'as' => 'admin.customer.paymentmethodattr.update',
        'uses' => 'PaymentMethodAttrController@update',
        'middleware' => 'can:customer.paymentmethodattrs.edit'
    ]);
    $router->delete('paymentmethodattrs/{paymentmethodattr}', [
        'as' => 'admin.customer.paymentmethodattr.destroy',
        'uses' => 'PaymentMethodAttrController@destroy',
        'middleware' => 'can:customer.paymentmethodattrs.destroy'
    ]);
    $router->bind('paymentmethodcustomer', function ($id) {
        return app('Modules\Customer\Repositories\PaymentMethodCustomerRepository')->find($id);
    });
    $router->get('paymentmethodcustomers', [
        'as' => 'admin.customer.paymentmethodcustomer.index',
        'uses' => 'PaymentMethodCustomerController@index',
        'middleware' => 'can:customer.paymentmethodcustomers.index'
    ]);
    $router->get('paymentmethodcustomers/create', [
        'as' => 'admin.customer.paymentmethodcustomer.create',
        'uses' => 'PaymentMethodCustomerController@create',
        'middleware' => 'can:customer.paymentmethodcustomers.create'
    ]);
    $router->post('paymentmethodcustomers', [
        'as' => 'admin.customer.paymentmethodcustomer.store',
        'uses' => 'PaymentMethodCustomerController@store',
        'middleware' => 'can:customer.paymentmethodcustomers.create'
    ]);
    $router->get('paymentmethodcustomers/{paymentmethodcustomer}/edit', [
        'as' => 'admin.customer.paymentmethodcustomer.edit',
        'uses' => 'PaymentMethodCustomerController@edit',
        'middleware' => 'can:customer.paymentmethodcustomers.edit'
    ]);
    $router->put('paymentmethodcustomers/{paymentmethodcustomer}', [
        'as' => 'admin.customer.paymentmethodcustomer.update',
        'uses' => 'PaymentMethodCustomerController@update',
        'middleware' => 'can:customer.paymentmethodcustomers.edit'
    ]);
    $router->delete('paymentmethodcustomers/{paymentmethodcustomer}', [
        'as' => 'admin.customer.paymentmethodcustomer.destroy',
        'uses' => 'PaymentMethodCustomerController@destroy',
        'middleware' => 'can:customer.paymentmethodcustomers.destroy'
    ]);
    $router->bind('paymentmethodcustomerattr', function ($id) {
        return app('Modules\Customer\Repositories\PaymentMethodCustomerAttrRepository')->find($id);
    });
    $router->get('paymentmethodcustomerattrs', [
        'as' => 'admin.customer.paymentmethodcustomerattr.index',
        'uses' => 'PaymentMethodCustomerAttrController@index',
        'middleware' => 'can:customer.paymentmethodcustomerattrs.index'
    ]);
    $router->get('paymentmethodcustomerattrs/create', [
        'as' => 'admin.customer.paymentmethodcustomerattr.create',
        'uses' => 'PaymentMethodCustomerAttrController@create',
        'middleware' => 'can:customer.paymentmethodcustomerattrs.create'
    ]);
    $router->post('paymentmethodcustomerattrs', [
        'as' => 'admin.customer.paymentmethodcustomerattr.store',
        'uses' => 'PaymentMethodCustomerAttrController@store',
        'middleware' => 'can:customer.paymentmethodcustomerattrs.create'
    ]);
    $router->get('paymentmethodcustomerattrs/{paymentmethodcustomerattr}/edit', [
        'as' => 'admin.customer.paymentmethodcustomerattr.edit',
        'uses' => 'PaymentMethodCustomerAttrController@edit',
        'middleware' => 'can:customer.paymentmethodcustomerattrs.edit'
    ]);
    $router->put('paymentmethodcustomerattrs/{paymentmethodcustomerattr}', [
        'as' => 'admin.customer.paymentmethodcustomerattr.update',
        'uses' => 'PaymentMethodCustomerAttrController@update',
        'middleware' => 'can:customer.paymentmethodcustomerattrs.edit'
    ]);
    $router->delete('paymentmethodcustomerattrs/{paymentmethodcustomerattr}', [
        'as' => 'admin.customer.paymentmethodcustomerattr.destroy',
        'uses' => 'PaymentMethodCustomerAttrController@destroy',
        'middleware' => 'can:customer.paymentmethodcustomerattrs.destroy'
    ]);
// append












});
