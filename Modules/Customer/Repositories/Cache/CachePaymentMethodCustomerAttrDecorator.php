<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\PaymentMethodCustomerAttrRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePaymentMethodCustomerAttrDecorator extends BaseCacheDecorator implements PaymentMethodCustomerAttrRepository
{
    public function __construct(PaymentMethodCustomerAttrRepository $paymentmethodcustomerattr)
    {
        parent::__construct();
        $this->entityName = 'customer.paymentmethodcustomerattrs';
        $this->repository = $paymentmethodcustomerattr;
    }
}
