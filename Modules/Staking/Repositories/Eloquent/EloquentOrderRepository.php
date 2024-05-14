<?php

namespace Modules\Staking\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Staking\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $orders = $this->allWithBuilder();

        $orders->whereHas('term', function (Builder $q) {
            $q->whereHas('package');
        });
        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $orders->where('code', 'LIKE', "%{$term}%")->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $orders->orderBy($request->get('order_by'), $order);
        } else {
            $orders->orderBy('created_at', 'desc');
        }

        return $orders->paginate($request->get('per_page', 10));
    }

    public function getListMyStake($customerId, Request $request): LengthAwarePaginator
    {
        $orders = $this->allWithBuilder();
        $orders->where('customer_id', $customerId);
        $orders->whereHas('term', function (Builder $q) {
            $q->whereHas('package');
        });
        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $orders->where('code', 'LIKE', "%{$term}%")->orWhere('id', $term);
        }
        $orders->orderBy('created_at', 'desc');
        return $orders->paginate($request->get('per_page', 10));
    }
}
