<?php

namespace Modules\Staking\Repositories\Cache;

use Modules\Staking\Repositories\RewardRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRewardDecorator extends BaseCacheDecorator implements RewardRepository
{
    public function __construct(RewardRepository $reward)
    {
        parent::__construct();
        $this->entityName = 'staking.rewards';
        $this->repository = $reward;
    }
}
