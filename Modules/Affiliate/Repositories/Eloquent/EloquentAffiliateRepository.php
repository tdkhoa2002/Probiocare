<?php

namespace Modules\Affiliate\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentAffiliateRepository extends EloquentBaseRepository implements AffiliateRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $orders = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $orders->where('type', 'LIKE', "%{$term}%");
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $orders->orderBy($request->get('order_by'), $order);
        } else {
            $orders->orderBy('id', 'desc');
        }

        return $orders->paginate($request->get('per_page', 10));
    }

    public function getAffiliateLastLevel($type)
    {
        return $this->allWithBuilder()->where('type', $type)->orderBy('level', 'DESC')->first();
    }
}
