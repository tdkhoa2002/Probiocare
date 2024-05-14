<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\CustomerKycRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomerKycDecorator extends BaseCacheDecorator implements CustomerKycRepository
{
    public function __construct(CustomerKycRepository $customerkyc)
    {
        parent::__construct();
        $this->entityName = 'customer.customerkycs';
        $this->repository = $customerkyc;
    }
}
