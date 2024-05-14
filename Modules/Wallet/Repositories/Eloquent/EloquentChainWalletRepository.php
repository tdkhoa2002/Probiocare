<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\ChainWalletRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentChainWalletRepository extends EloquentBaseRepository implements ChainWalletRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $chainWallets = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $chainWallets->where('address',  "%{$term}%")->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $chainWallets->orderBy($request->get('order_by'), $order);
        }

        return $chainWallets->paginate($request->get('per_page', 10));
    }

    public function create($data)
    {
        $data['private_key'] = encodeString($data['private_key']);
        return $this->model->create($data);
    }

    public function update($model, $data)
    {
        unset($data['address']);
        unset($data['private_key']);
        return $model->update($data);
    }

    public function findChainWalletAvaliable($blockchainId)
    {
        return $this->model->where('blockchain_id', $blockchainId)->where('using', false)->first();
    }

    public function findChainWalletByAddress($address)
    {
        return $this->model->where('address', 'LIKE', "%{$address}%")->first();
    }
}
