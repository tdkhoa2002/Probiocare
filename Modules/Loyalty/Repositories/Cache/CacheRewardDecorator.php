<?php

namespace Modules\Loyalty\Repositories\Cache;

use Modules\Loyalty\Repositories\RewardRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRewardDecorator extends BaseCacheDecorator implements RewardRepository
{
    public function __construct(RewardRepository $reward)
    {
        parent::__construct();
        $this->entityName = 'loyalty.rewards';
        $this->repository = $reward;
    }
}
