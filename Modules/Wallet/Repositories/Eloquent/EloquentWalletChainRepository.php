<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentWalletChainRepository extends EloquentBaseRepository implements WalletChainRepository
{
    public function findWalletChainByBlockchain($customerId, $blockchainIds)
    {
        return $this->model->whereHas('wallet', function (Builder $query) use ($customerId) {
            $query->where('wallet__wallets.customer_id', $customerId);
        })->whereIn('blockchain_id', $blockchainIds)->first();
    }

    public function findWalletByAddress($address)
    {
        return $this->model->where('address', "LIKE", "%{$address}%")->first();
    }

    public function findWalletByAddressAndCurrency($address, $currencyId)
    {
        return $this->model
            ->whereHas('wallet', function (Builder $query) use ($currencyId) {
                $query->where('wallet__wallets.currency_id', $currencyId);
            })
            ->where('address', 'LIKE', "%{$address}%")
            ->first();
    }

    public function getWalletCanCrawl($onhold, $blockchainId, $currencyId)
    {
        return $this->model
            ->whereHas('wallet', function (Builder $query) use ($currencyId) {
                $query->where('wallet__wallets.currency_id', $currencyId);
            })
            ->where('blockchain_id', $blockchainId)
            ->where('onhold', ">=", $onhold)
            ->where('is_sync', true)
            ->get();
    }
}
