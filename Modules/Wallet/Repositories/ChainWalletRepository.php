<?php

namespace Modules\Wallet\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface ChainWalletRepository extends BaseRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;
    public function findChainWalletAvaliable($blockchainId);
    public function findChainWalletByAddress($address);
}
