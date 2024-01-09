<?php

namespace Modules\Loyalty\Repositories\Cache;

use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePackageDecorator extends BaseCacheDecorator implements PackageRepository
{
    public function __construct(PackageRepository $package)
    {
        parent::__construct();
        $this->entityName = 'loyalty.packages';
        $this->repository = $package;
    }
}
