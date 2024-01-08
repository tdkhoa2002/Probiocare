<?php

namespace Modules\MarketMaker\Repositories\Cache;

use Modules\MarketMaker\Repositories\VolumnizerRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheVolumnizerDecorator extends BaseCacheDecorator implements VolumnizerRepository
{
    public function __construct(VolumnizerRepository $volumnizer)
    {
        parent::__construct();
        $this->entityName = 'marketmaker.volumnizers';
        $this->repository = $volumnizer;
    }
}
