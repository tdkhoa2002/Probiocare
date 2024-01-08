<?php

namespace Modules\Trade\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentMarketRepository extends EloquentBaseRepository implements MarketRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $markets = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $markets->where('symbol',  "%{$term}%")->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $markets->orderBy($request->get('order_by'), $order);
        }

        return $markets->paginate($request->get('per_page', 10));
    }

    public function getListMarket(Request $request): LengthAwarePaginator
    {
        $markets = $this->allWithBuilder();
        $markets->where('status', true);
        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $markets->where('symbol',  "LIKE", "%{$term}%");
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $markets->orderBy($request->get('order_by'), $order);
        } else {
            $markets->orderBy('created_at', 'desc');
        }

        return $markets->paginate($request->get('per_page', 10));
    }
}
