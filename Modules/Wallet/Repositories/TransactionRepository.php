<?php

namespace Modules\Wallet\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface TransactionRepository extends BaseRepository
{
    public function getListTransaction($customer_id,$action, Request $request): LengthAwarePaginator;
    public function getTxnsByAction($customer_id, array $actions);
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
    public function getTransactionStaking($orderId);
    public function getWithdrawInDay($currencyId, $customerId);
}
