<?php

namespace Modules\MarketMaker\Repositories\Cache;

use Modules\MarketMaker\Repositories\TargetPriceRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTargetPriceDecorator extends BaseCacheDecorator implements TargetPriceRepository
{
    public function __construct(TargetPriceRepository $targetprice)
    {
        parent::__construct();
        $this->entityName = 'marketmaker.targetprices';
        $this->repository = $targetprice;
    }
}
