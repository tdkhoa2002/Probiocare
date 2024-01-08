<?php

namespace Modules\Trade\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface TradeRepository extends BaseRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
    public function countMyAllTrade($customerId, $trade_type, $status, $from = 0, $to = 0);
    public function getListMyOrders($customerId, $status, $type, $symbol, Request $request): LengthAwarePaginator;
}
