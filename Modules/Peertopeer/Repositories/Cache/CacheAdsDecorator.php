<?php

namespace Modules\Peertopeer\Repositories\Cache;

use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAdsDecorator extends BaseCacheDecorator implements AdsRepository
{
    public function __construct(AdsRepository $ads)
    {
        parent::__construct();
        $this->entityName = 'peertopeer.ads';
        $this->repository = $ads;
    }
}
