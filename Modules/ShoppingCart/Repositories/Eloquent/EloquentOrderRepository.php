<?php

namespace Modules\ShoppingCart\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\ShoppingCart\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $orderData = $this->allWithBuilder();
        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $orderData->where('order_code','LIKE', "%{$term}%");
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $orderData->orderBy($request->get('order_by'), $order);
        }else {
            $orderData->orderBy('id', 'desc');
        }

        return $orderData->paginate($request->get('per_page', 10));
    }
}
