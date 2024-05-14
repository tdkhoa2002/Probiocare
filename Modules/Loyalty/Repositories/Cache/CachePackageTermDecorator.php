<?php

namespace Modules\Loyalty\Repositories\Cache;

use Modules\Loyalty\Repositories\PackageTermRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePackageTermDecorator extends BaseCacheDecorator implements PackageTermRepository
{
    public function __construct(PackageTermRepository $packageterm)
    {
        parent::__construct();
        $this->entityName = 'loyalty.packageterms';
        $this->repository = $packageterm;
    }
}
