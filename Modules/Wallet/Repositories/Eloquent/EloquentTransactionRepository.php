<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentTransactionRepository extends EloquentBaseRepository implements TransactionRepository
{
    public function getListTransaction($customer_id, $action, Request $request): LengthAwarePaginator
    {
        $transactions = $this->allWithBuilder();
        $transactions->where('customer_id', $customer_id);
        if ($action != "ALL") {
            $transactions->where('action', $action);
        }
        if ($request->has('tx') && $request->get('tx') !== "") {
            $transactions->where('txhash', 'LIKE', $request->get('tx'));
        }
        if ($request->has('action') && $request->get('action') != "") {
            $transactions->where('action', $request->get('action'));
        }
        if ($request->has('currency') && $request->get('currency') != "") {
            $transactions->where('currency_id', $request->get('currency'));
        }

        if ($request->has('network') && $request->get('network') != "") {
            $transactions->where('blockchain_id', $request->get('network'));
        }
        $transactions->orderBy('created_at', 'DESC');
        return $transactions->paginate($request->get('per_page', 10));
    }

    public function getTxnsByAction($customerId, array $actions)
    {
        $transactions = $this->allWithBuilder();
        $transactions->select('action')
                    ->selectRaw('SUM(amount_usd) as total')
                    ->where('customer_id', $customerId)
                    ->where('status', 'COMPLETED')
                    ->whereIn('action', $actions);

        if(count($actions) > 0) {
            $transactions->groupBy('action');
        }
        
        return $transactions->get();
    }

    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $transactions = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $transactions->where('txhash', "LIKE", "%{$term}%")->orWhere('to', $term)->orWhere('id', $term);
        }

        if ($request->has('action') && $request->get('action') != "") {
            $transactions->where('action', $request->get('action'));
        }

        if ($request->has('status') && $request->get('status') != "") {
            $transactions->where('status', $request->get('status'));
        }

        if ($request->has('currency') && $request->get('currency') != "") {
            $transactions->where('currency_id', $request->get('currency'));
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $transactions->orderBy($request->get('order_by'), $order);
        } else {
            $transactions->orderBy('created_at', 'DESC');
        }

        return $transactions->paginate($request->get('per_page', 10));
    }

    public function getTransactionStaking($orderId)
    {
        $transactions = $this->allWithBuilder();
        $transactions->where('order', $orderId)->whereIn('action', ['STAKING', 'UN_STAKING', 'REWARD_STAKING', 'COMMISSION_STAKING']);
        $transactions->orderBy('created_at', 'DESC');
        return $transactions->get();
    }

    public function getWithdrawInDay($currencyId, $customerId)
    {
        $transactions = $this->allWithBuilder();
        $transactions
            ->where('customer_id', $customerId)
            ->where('currency_id', $currencyId)
            ->whereDate('created_at', Carbon::today())
            ->where('action', 'WITHDRAW');
        $transactions->orderBy('created_at', 'DESC');
        return $transactions->get();
    }
}
