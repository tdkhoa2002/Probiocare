<?php

namespace Modules\Cryperrswap\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Cryperrswap\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCurrencyRepository extends EloquentBaseRepository implements CurrencyRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $currencies = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $currencies
                ->where('code', 'LIKE', "%{$term}%")
                ->orWhere('name', 'LIKE', "%{$term}%")
                ->orWhere('coin', 'LIKE', "%{$term}%")
                ->orWhere('network', 'LIKE', "%{$term}%")
                ->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            $currencies->orderBy($request->get('order_by'), $order);
        }

        return $currencies->paginate($request->get('per_page', 10));
    }
}
