<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\CustomerProfileRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomerProfileDecorator extends BaseCacheDecorator implements CustomerProfileRepository
{
    public function __construct(CustomerProfileRepository $customerprofile)
    {
        parent::__construct();
        $this->entityName = 'customer.customerprofiles';
        $this->repository = $customerprofile;
    }
}
