<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentWalletRepository extends EloquentBaseRepository implements WalletRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $wallets = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            if (isset($term['customer_id']) && $term['customer_id'] !=  null) {
                $wallets->where('customer_id', $term['customer_id']);
            }
            if (isset($term['currency_id']) && $term['currency_id'] !=  null) {
                $wallets->where('currency_id', $term['currency_id']);
            }
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $wallets->orderBy($request->get('order_by'), $order);
        } else {
            $wallets->orderBy('created_at', 'DESC');
        }

        return $wallets->paginate($request->get('per_page', 10));
    }
}
