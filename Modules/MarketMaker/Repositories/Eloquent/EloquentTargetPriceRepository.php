<?php

namespace Modules\MarketMaker\Repositories\Eloquent;

use Modules\MarketMaker\Repositories\TargetPriceRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentTargetPriceRepository extends EloquentBaseRepository implements TargetPriceRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $targetPrices = $this->allWithBuilder();
        if ($request->has('search') && $request->input('search') !== "") {
            $term = $request->input('search');
            $targetPrices->whereHas('market', function ($q) use ($term) {
                $q->where('symbol', 'like', "%{$term}%");
            });
        }

        if ($request->has('pair')) {
            $term = $request->get('pair');
            $targetPrices->whereHas('market', function ($q) use ($term) {
                $q->where('symbol', 'like', "%{$term}%");
            });
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $targetPrices->orderBy($request->get('order_by'), $order);
        }
        else {
            $targetPrices->orderBy('schedule', 'desc');
        }
        return $targetPrices->paginate($request->get('per_page', 10));
    }
}
