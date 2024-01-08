<?php

namespace Modules\Peertopeer\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Peertopeer\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
    public function getMyOrder($customerId, Request $request): LengthAwarePaginator
    {
        $orders = $this->allWithBuilder();
        $orders->where('customer_id', $customerId);
        if ($request->get('status') && $request->get('status') != null && $request->get('status') != "ALL") {
            $orders->where('status', $request->get('status'));
        }
        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $orders->orderBy($request->get('order_by'), $order);
        } else {
            $orders->orderBy('id', 'desc');
        }
        return $orders->paginate($request->get('per_page', 10));
    }

    public function getAgentOrders($customerId, Request $request): LengthAwarePaginator
    {
        $orders = $this->allWithBuilder();
        $orders->whereHas('ad', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        });
        if ($request->get('status') && $request->get('status') != null && $request->get('status') != "ALL") {
            $orders->where('status', $request->get('status'));
        }
        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $orders->orderBy($request->get('order_by'), $order);
        } else {
            $orders->orderBy('id', 'desc');
        }
        return $orders->paginate($request->get('per_page', 10));
    }

    public function findOrderAgent($orderId, $customerId)
    {
        $order = $this->allWithBuilder();
        $order->where('id', $orderId);
        $order->whereHas('ad', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        });

        return $order->first();
    }

    public function getOrderPending()
    {
        return $this->allWithBuilder()->whereIn('status', [0, 1])->orderBy('created_at', 'asc')->get();
    }

    public function countMyAllTrade($customerId, $type, $status, $from = 0, $to = 0)
    {
        $orders = $this->allWithBuilder();
        $orders->where('customer_id', $customerId);
        if ($type !== 'ALL') {
            $orders->where('type', $type);
        }
        if ($status !== 'ALL') {
            $orders->where('status', $status);
        }
        if ($from !== 0) {
            $orders->where('created_at', '>=', $from);
        }
        if ($to !== 0) {
            $orders->where('created_at', '<=', $to);
        }
        return $orders->count();
    }
}
