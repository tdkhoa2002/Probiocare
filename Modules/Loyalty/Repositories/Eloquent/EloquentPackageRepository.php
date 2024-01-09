<?php

namespace Modules\Loyalty\Repositories\Eloquent;

use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentPackageRepository extends EloquentBaseRepository implements PackageRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $packages = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $packages->where('name',  "%{$term}%")->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $packages->orderBy($request->get('order_by'), $order);
        }

        return $packages->paginate($request->get('per_page', 10));
    }

    public function getPackagesList()
    {
        $packages = $this->allWithBuilder();
        $packages->where('status', true);
        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $packages->where('name',  "LIKE", "%{$term}%");
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';
            $packages->orderBy($request->get('order_by'), $order);
        } else {
            $packages->orderBy('created_at', 'desc');
        }

        return $packages->paginate($request->get('per_page', 10));
    }
}
