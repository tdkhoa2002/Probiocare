<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\PaymentMethodCustomerRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePaymentMethodCustomerDecorator extends BaseCacheDecorator implements PaymentMethodCustomerRepository
{
    public function __construct(PaymentMethodCustomerRepository $paymentmethodcustomer)
    {
        parent::__construct();
        $this->entityName = 'customer.paymentmethodcustomers';
        $this->repository = $paymentmethodcustomer;
    }
}
