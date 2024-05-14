<?php

namespace Modules\ShoppingCart\Repositories\Cache;

use Modules\ShoppingCart\Repositories\OrderDetailRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderDetailDecorator extends BaseCacheDecorator implements OrderDetailRepository
{
    public function __construct(OrderDetailRepository $orderdetail)
    {
        parent::__construct();
        $this->entityName = 'shoppingcart.orderdetails';
        $this->repository = $orderdetail;
    }
}
