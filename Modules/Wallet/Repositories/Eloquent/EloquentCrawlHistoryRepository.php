<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\CrawlHistoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCrawlHistoryRepository extends EloquentBaseRepository implements CrawlHistoryRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $blockchains = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $blockchains->where('txhash',  "%{$term}%");
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $blockchains->orderBy($request->get('order_by'), $order);
        }

        return $blockchains->paginate($request->get('per_page', 10));
    }

}
