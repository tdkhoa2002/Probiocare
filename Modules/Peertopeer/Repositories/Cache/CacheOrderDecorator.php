<?php

namespace Modules\Peertopeer\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Peertopeer\Repositories\OrderRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderDecorator extends BaseCacheDecorator implements OrderRepository
{
    public function __construct(OrderRepository $order)
    {
        parent::__construct();
        $this->entityName = 'peertopeer.orders';
        $this->repository = $order;
    }
    
    public function getMyOrder($customerId, Request $request): LengthAwarePaginator {
        
    }

    public function getAgentOrders($customerId, Request $request): LengthAwarePaginator {
        
    }

    public function findOrderAgent($orderId, $customerId) {
        
    }

    public function getOrderPending(){
        
    }

    public function countMyAllTrade($customerId, $trade_type, $status, $from = 0, $to = 0)
    {
        $key = $this->getBaseKey() . "countMyAllTrade.{$customerId}-{$trade_type}-{$status}-{$from}-{ $to}";

        return $this->remember(function () use ($customerId, $trade_type, $status, $from, $to) {
            return $this->repository->countMyAllTrade($customerId, $trade_type, $status, $from, $to);
        }, $key);
    }
}
