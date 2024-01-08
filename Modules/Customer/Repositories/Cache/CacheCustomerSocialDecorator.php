<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\CustomerSocialRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCustomerSocialDecorator extends BaseCacheDecorator implements CustomerSocialRepository
{
    public function __construct(CustomerSocialRepository $customersocial)
    {
        parent::__construct();
        $this->entityName = 'customer.customersocials';
        $this->repository = $customersocial;
    }
}
