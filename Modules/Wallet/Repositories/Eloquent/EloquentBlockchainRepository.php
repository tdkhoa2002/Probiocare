<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentBlockchainRepository extends EloquentBaseRepository implements BlockchainRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $blockchains = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $blockchains->where('code',  "%{$term}%")->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $blockchains->orderBy($request->get('order_by'), $order);
        }

        return $blockchains->paginate($request->get('per_page', 10));
    }

    
}
