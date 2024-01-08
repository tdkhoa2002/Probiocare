<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\CustomerCodeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomerCodeDecorator extends BaseCacheDecorator implements CustomerCodeRepository
{
    public function __construct(CustomerCodeRepository $customercode)
    {
        parent::__construct();
        $this->entityName = 'customer.customercodes';
        $this->repository = $customercode;
    }
}
