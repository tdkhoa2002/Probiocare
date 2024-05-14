<?php

namespace Modules\Customer\Repositories\Cache;

use Modules\Customer\Repositories\CountryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCountryDecorator extends BaseCacheDecorator implements CountryRepository
{
    public function __construct(CountryRepository $country)
    {
        parent::__construct();
        $this->entityName = 'customer.countries';
        $this->repository = $country;
    }
}
