<?php

namespace Modules\Wallet\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface WalletChainRepository extends BaseRepository
{
    public function findWalletChainByBlockchain($customerId,$blockchainIds);
    public function getWalletCanCrawl($onhold, $blockchainId, $currencyId);
    public function findWalletByAddress($address);
}
