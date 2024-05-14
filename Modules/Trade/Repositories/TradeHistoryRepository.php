<?php

namespace Modules\Trade\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TradeHistoryRepository extends BaseRepository
{
    public function getTradeHistories($marketId, $from, $to);
    public function getTradeHistoriesWithLimit($marketId, $limit, $to);
    public function getTradeHistoriesNewest($marketId, $limit = 500);
    public function getTradeHistory24H($marketId);
}
