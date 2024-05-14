<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Wallet\Events\CurrencyIsCreating;
use Modules\Wallet\Events\CurrencyIsUpdating;
use Modules\Wallet\Events\CurrencyWasCreated;
use Modules\Wallet\Events\CurrencyWasDeleted;
use Modules\Wallet\Events\CurrencyWasUpdated;

class EloquentCurrencyRepository extends EloquentBaseRepository implements CurrencyRepository
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
        if (isset($data['swap_enable'])) {
            if (count($data['swap_enable']) > 0) {
                $data['swap_enable'] = json_encode($data['swap_enable']);
            } else {
                $data['swap_enable'] = null;
            }
        }
        event($event = new CurrencyIsCreating($data));
        $Currency = $this->model->create($event->getAttributes());
        event(new CurrencyWasCreated($Currency, $data));
        return $Currency;
    }

    public function update($model, $data)
    {
        event($event = new CurrencyIsUpdating($model, $data));
        if (isset($data['swap_enable'])) {
            if (count($data['swap_enable']) > 0) {
                $data['swap_enable'] = json_encode($data['swap_enable']);
            } else {
                $data['swap_enable'] = null;
            }
        }
        $model->update($event->getAttributes());

        event(new CurrencyWasUpdated($model, $data));
        return $model;
    }

    public function destroy($Currency)
    {
        event(new CurrencyWasDeleted($Currency));

        return $Currency->delete();
    }

    public function getCurrencySwap()
    {
        return $this->allWithBuilder()->whereNotNull('swap_enable')
            ->where('type', 'CRYPTO')
            ->where('status', true)
            ->get();
    }

    public function getCurrencySwapEnable($ids)
    {
        return $this->whereIn('id', $ids)
            ->where('status', true)
            ->get();
    }
}
