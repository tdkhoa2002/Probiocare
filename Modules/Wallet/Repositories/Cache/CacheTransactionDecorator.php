<?php

namespace Modules\Wallet\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTransactionDecorator extends BaseCacheDecorator implements TransactionRepository
{
    public function __construct(TransactionRepository $transaction)
    {
        parent::__construct();
        $this->entityName = 'wallet.transactions';
        $this->repository = $transaction;
    }

    public function getListTransaction($customer_id, $action, Request $request): LengthAwarePaginator
    {
        $page = $request->get('page');
        $perPage = $request->get('per_page');
        $key = $this->getBaseKey() . "getListTransaction.{$customer_id}-{$page}-{$action}-{$perPage}";

        return $this->remember(function () use ($customer_id, $action, $request) {
            return $this->repository->getListTransaction($customer_id, $action, $request);
        }, $key);
    }

    public function getTxnsByAction($customerId, array $actions) {
        $key = $this->getBaseKey() . "getTxnsByAction.{$customerId}-{$actions}";
        return $this->remember(function () use ($customerId, $actions) {
            return $this->repository->getTxnsByAction($customerId, $actions);
        }, $key);
    }

    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $page = $request->get('page');
        $order = $request->get('order');
        $orderBy = $request->get('order_by');
        $perPage = $request->get('per_page');
        $search = $request->get('search');

        $key = $this->getBaseKey() . "serverPaginationFilteringFor.{$page}-{$order}-{$orderBy}-{$perPage}-{$search}";

        return $this->remember(function () use ($request) {
            return $this->repository->serverPaginationFilteringFor($request);
        }, $key);
    }

    public function getTransactionStaking($orderId)
    {
        $key = $this->getBaseKey() . "getTransactionStaking.{$orderId}";

        return $this->remember(function () use ($orderId) {
            return $this->repository->getTransactionStaking($orderId);
        }, $key);
    }

    public function getWithdrawInDay($currencyId, $customerId)
    {
        $key = $this->getBaseKey() . "getWithdrawInDay.{$currencyId}.{$customerId}";

        return $this->remember(function () use ($currencyId, $customerId) {
            return $this->repository->getWithdrawInDay($currencyId, $customerId);
        }, $key);
    }
}
