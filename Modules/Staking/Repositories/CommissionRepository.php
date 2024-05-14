<?php

namespace Modules\Staking\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CommissionRepository extends BaseRepository
{
    public function getCommissionLastLevel($packageId);
}
