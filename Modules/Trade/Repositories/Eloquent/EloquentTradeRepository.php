<?php

namespace Modules\Trade\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentTradeRepository extends EloquentBaseRepository implements TradeRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $trades = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            if (isset($term['market_id']) && $term['market_id'] != "") {
                $trades->where('market_id',  $term['market_id']);
            }
            if (isset($term['customer_id']) && $term['customer_id'] != "") {
                $trades->where('customer_id',  $term['customer_id']);
            }
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $trades->orderBy($request->get('order_by'), $order);
        } else {
            $trades->orderBy('created_at', 'desc');
        }

        return $trades->paginate($request->get('per_page', 10));
    }

    public function countMyAllTrade($customerId, $trade_type, $status, $from = 0, $to = 0)
    {
        $trades = $this->allWithBuilder();
        $trades->where('customer_id', $customerId);
        if ($trade_type !== 'ALL') {
            $trades->where('trade_type', $trade_type);
        }
        if ($status !== 'ALL') {
            $trades->where('status', $status);
        }
        if ($from !== 0) {
            $trades->where('created_at', '>=', $from);
        }
        if ($to !== 0) {
            $trades->where('created_at', '<=', $to);
        }
        return $trades->count();
    }

    public function getListMyOrders($customerId, $status, $type, $symbol, Request $request): LengthAwarePaginator {
        $orders = $this->allWithBuilder();
        $orders->where('customer_id', $customerId);
        if ($symbol !== null) {
            $orders->where('market_id', $symbol->id);
        }
        if ($type !== null) {
            $orders->where('trade_type', $type);
        }
        if ($status !== null) {
            $orders->where('status', $status);
        }
        $orders->orderBy('created_at', 'desc');
        return $orders->paginate($request->get('per_page', 10));
    }
}
