<?php

namespace Modules\Wallet\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCurrencyDecorator extends BaseCacheDecorator implements CurrencyRepository
{
    public function __construct(CurrencyRepository $currency)
    {
        parent::__construct();
        $this->entityName = 'wallet.currencies';
        $this->repository = $currency;
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

    public function getCurrencySwap()
    {
        $key = $this->getBaseKey() . "getCurrencySwap";

        return $this->remember(function () {
            return $this->repository->getCurrencySwap();
        }, $key);
    }

    public function getCurrencySwapEnable($ids)
    {
        $key = $this->getBaseKey() . "getCurrencySwapEnable" . implode("-", $ids);

        return $this->remember(function () use ($ids) {
            return $this->repository->getCurrencySwapEnable($ids);
        }, $key);
    }
}
