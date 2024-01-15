<?php

namespace Modules\Loyalty\Repositories\Cache;

use Modules\Loyalty\Repositories\CommissionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCommissionDecorator extends BaseCacheDecorator implements CommissionRepository
{
    public function __construct(CommissionRepository $commission)
    {
        parent::__construct();
        $this->entityName = 'loyalty.commissions';
        $this->repository = $commission;
    }

    public function getCommissionLastLevel($packageId)
    {
        $key = $this->getBaseKey() . "getCommissionLastLevel" . $packageId;

        return $this->remember(function () use ($packageId) {
            return $this->repository->getCommissionLastLevel($packageId);
        }, $key);
    }
}
