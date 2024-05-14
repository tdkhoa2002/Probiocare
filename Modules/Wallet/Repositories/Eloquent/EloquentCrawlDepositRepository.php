<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\CrawlDepositRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCrawlDepositRepository extends EloquentBaseRepository implements CrawlDepositRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $crawlDeposits = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $crawlDeposits->whereHas('crawlHistories', function ($q) use ($term) {
                $q->where('txhash', 'LIKE', "%{$term}%");
            });
        }
        $crawlDeposits->orderBy('created_at', 'DESC');
        return $crawlDeposits->paginate($request->get('per_page', 10));
    }
}
