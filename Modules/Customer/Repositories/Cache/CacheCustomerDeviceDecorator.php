<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\CustomerDeviceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomerDeviceDecorator extends BaseCacheDecorator implements CustomerDeviceRepository
{
    public function __construct(CustomerDeviceRepository $customerdevice)
    {
        parent::__construct();
        $this->entityName = 'customer.customerdevices';
        $this->repository = $customerdevice;
    }
}
