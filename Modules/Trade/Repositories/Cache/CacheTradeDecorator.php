<?php

namespace Modules\Trade\Repositories\Cache;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTradeDecorator extends BaseCacheDecorator implements TradeRepository
{
    public function __construct(TradeRepository $trade)
    {
        parent::__construct();
        $this->entityName = 'trade.trades';
        $this->repository = $trade;
    }

    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $page = $request->get('page');
        $order = $request->get('order');
        $orderBy = $request->get('order_by');
        $perPage = $request->get('per_page');
        $search = $request->get('search');
        $search = implode('-', $search);
        $key = $this->getBaseKey() . "serverPaginationFilteringFor.{$page}-{$order}-{$orderBy}-{$perPage}-{ $search}";

        return $this->remember(function () use ($request) {
            return $this->repository->serverPaginationFilteringFor($request);
        }, $key);
    }

    public function countMyAllTrade($customerId, $trade_type, $status, $from = 0, $to = 0)
    {
        $key = $this->getBaseKey() . "countMyAllTrade.{$customerId}-{$trade_type}-{$status}-{$from}-{ $to}";

        return $this->remember(function () use ($customerId, $trade_type, $status, $from, $to) {
            return $this->repository->countMyAllTrade($customerId, $trade_type, $status, $from, $to);
        }, $key);
    }
}
