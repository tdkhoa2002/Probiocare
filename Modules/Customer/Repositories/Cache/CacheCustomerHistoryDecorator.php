<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\CustomerHistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomerHistoryDecorator extends BaseCacheDecorator implements CustomerHistoryRepository
{
    public function __construct(CustomerHistoryRepository $customerhistory)
    {
        parent::__construct();
        $this->entityName = 'customer.customerhistories';
        $this->repository = $customerhistory;
    }
}
