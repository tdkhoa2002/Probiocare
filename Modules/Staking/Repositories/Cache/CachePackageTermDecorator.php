<?php

namespace Modules\Staking\Repositories\Cache;

use Modules\Staking\Repositories\PackageTermRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePackageTermDecorator extends BaseCacheDecorator implements PackageTermRepository
{
    public function __construct(PackageTermRepository $packageterm)
    {
        parent::__construct();
        $this->entityName = 'staking.packageterms';
        $this->repository = $packageterm;
    }
}
