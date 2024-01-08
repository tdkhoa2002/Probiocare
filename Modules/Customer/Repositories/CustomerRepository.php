<?php

namespace Modules\Customer\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Core\Repositories\BaseRepository;

interface CustomerRepository extends BaseRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator;

    public function getCustomerWithFloor($sponsor_floor);

    public function getCustomerDirectMember($sponsor_id);

    public function createAdmin($data);
}
