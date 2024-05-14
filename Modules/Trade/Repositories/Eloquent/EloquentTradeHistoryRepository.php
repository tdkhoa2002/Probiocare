<?php

namespace Modules\Trade\Repositories\Eloquent;

use Carbon\Carbon;
use Modules\Trade\Repositories\TradeHistoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentTradeHistoryRepository extends EloquentBaseRepository implements TradeHistoryRepository
{
    public function getTradeHistories($marketId, $from, $to)
    {
        return $this->model->whereHas('trade', function ($q) use ($marketId) {
            $q->where('market_id', $marketId);
        })->whereBetween('created_at', [Carbon::createFromTimestamp($from)->toDateTimeString(), Carbon::createFromTimestamp($to)->toDateTimeString()])->get();
    }

    public function getTradeHistoriesWithLimit($marketId, $limit, $to)
    {
        return $this->model->whereHas('trade', function ($q) use ($marketId) {
            $q->where('market_id', $marketId);
        })->where('created_at', '<=', Carbon::createFromTimestamp($to)->toDateTimeString())->limit($limit)->get();
    }

    public function getTradeHistoriesNewest($marketId, $limit = 500)
    {
        return $this->model->whereHas('trade', function ($q) use ($marketId) {
            $q->where('market_id', $marketId);
        })->limit($limit)->orderBy('created_at', 'desc')->get();
    }

    public function getTradeHistory24H($marketId)
    {
        $now = now();
        $lastest = now()->subHours(24);
        return $this->model->whereHas('trade', function ($q) use ($marketId) {
            $q->where('market_id', $marketId);
        })
            ->where('created_at', '>=', $lastest->toDateTimeString())
            ->where('created_at', '<=', $now->toDateTimeString())
            ->orderBy('price', 'desc')
            ->get();
    }
}
