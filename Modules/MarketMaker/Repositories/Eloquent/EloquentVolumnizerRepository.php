<?php

namespace Modules\MarketMaker\Repositories\Eloquent;

use Modules\MarketMaker\Repositories\VolumnizerRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentVolumnizerRepository extends EloquentBaseRepository implements VolumnizerRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator {
        $volumnizers = $this->allWithBuilder();
        if ($request->has('search') && $request->input('search') !== "") {
            $term = $request->input('search');
            $volumnizers->whereHas('market', function ($q) use ($term) {
                $q->where('symbol', 'like', "%{$term}%");
            });
        }

        if ($request->has('pair')) {
            $term = $request->get('pair');
            $volumnizers->whereHas('market', function ($q) use ($term) {
                $q->where('symbol', 'like', "%{$term}%");
            });
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $volumnizers->orderBy($request->get('order_by'), $order);
        }
        else {
            $volumnizers->orderBy('start_time', 'desc');
        }
        return $volumnizers->paginate($request->get('per_page', 10));
    }
}
