<?php

namespace Modules\Peertopeer\Repositories\Cache;

use Modules\Peertopeer\Repositories\OrderHistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderHistoryDecorator extends BaseCacheDecorator implements OrderHistoryRepository
{
    public function __construct(OrderHistoryRepository $orderhistory)
    {
        parent::__construct();
        $this->entityName = 'peertopeer.orderhistories';
        $this->repository = $orderhistory;
    }
}
