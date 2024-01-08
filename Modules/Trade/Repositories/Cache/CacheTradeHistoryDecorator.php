<?php

namespace Modules\Trade\Repositories\Cache;

use Modules\Trade\Repositories\TradeHistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTradeHistoryDecorator extends BaseCacheDecorator implements TradeHistoryRepository
{
    public function __construct(TradeHistoryRepository $tradehistory)
    {
        parent::__construct();
        $this->entityName = 'trade.tradehistories';
        $this->repository = $tradehistory;
    }

    public function getTradeHistories($marketId, $from, $to)
    {
        $key = $this->getBaseKey() . "getTradeHistories.{$marketId}-{$from}-{$to}";

        return $this->remember(function () use ($marketId, $from, $to) {
            return $this->repository->getTradeHistories($marketId, $from, $to);
        }, $key);
    }

    public function getTradeHistoriesWithLimit($marketId, $limit, $to)
    {
        $key = $this->getBaseKey() . "getTradeHistoriesWithLimit.{$marketId}-{$limit}-{$to}";

        return $this->remember(function () use ($marketId, $limit, $to) {
            return $this->repository->getTradeHistoriesWithLimit($marketId, $limit, $to);
        }, $key);
    }

    public function getTradeHistoriesNewest($marketId, $limit = 500)
    {
        $key = $this->getBaseKey() . "getTradeHistoriesNewest.{$marketId}-{$limit}";

        return $this->remember(function () use ($marketId, $limit) {
            return $this->repository->getTradeHistoriesNewest($marketId, $limit);
        }, $key);
    }

    public function getTradeHistory24H($marketId) {
        $key = $this->getBaseKey() . "getTradeHistory24H.{$marketId}";

        return $this->remember(function () use ($marketId) {
            return $this->repository->getTradeHistory24H($marketId);
        }, $key);  
    }
}
