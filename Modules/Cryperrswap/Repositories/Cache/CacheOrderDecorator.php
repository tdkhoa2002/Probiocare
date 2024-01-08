<?php

namespace Modules\Cryperrswap\Repositories\Cache;

use Modules\Cryperrswap\Repositories\OrderRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderDecorator extends BaseCacheDecorator implements OrderRepository
{
    public function __construct(OrderRepository $order)
    {
        parent::__construct();
        $this->entityName = 'cryperrswap.orders';
        $this->repository = $order;
    }

    public function getOrderProccess()
    {
        $key = $this->getBaseKey() . "getOrderProccess";

        return $this->remember(function () {
            return $this->repository->getOrderProccess();
        }, $key);
    }
}
