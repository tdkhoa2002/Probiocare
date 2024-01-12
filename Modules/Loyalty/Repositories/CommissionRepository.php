<?php

namespace Modules\Loyalty\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CommissionRepository extends BaseRepository
{
    public function getCommissionLastLevel($packageId);
}
