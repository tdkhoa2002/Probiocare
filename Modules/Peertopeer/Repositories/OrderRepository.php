<?php

namespace Modules\Peertopeer\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface OrderRepository extends BaseRepository
{
    public function getMyOrder($customerId, Request $request): LengthAwarePaginator;
    public function getAgentOrders($customerId, Request $request): LengthAwarePaginator;
    public function findOrderAgent($orderId, $customerId);
    public function getOrderPending();
    public function countMyAllTrade($customerId, $type, $status, $from = 0, $to = 0);
}
