<?php

namespace Modules\Staking\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Staking\Repositories\PackageRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentPackageRepository extends EloquentBaseRepository implements PackageRepository
{
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $packages = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $packages->whereHas('translations', function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%");
            })->orWhere('id', $term);
        }


        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            if (Str::contains($request->get('order_by'), '.')) {
                $fields = explode('.', $request->get('order_by'));

                $packages->with('translations')->join('staking__package_translations as t', function ($join) {
                    $join->on('staking__packages.id', '=', 't.package_id');
                })
                    ->where('t.locale', locale())
                    ->groupBy('staking__packages.id')->orderBy("t.{$fields[1]}", $order);
            } else {
                $packages->orderBy($request->get('order_by'), $order);
            }
        }

        return $packages->paginate($request->get('per_page', 10));
    }

    public function getPackagesList()
    {
        $packages = $this->allWithBuilder();
        $packages->whereHas('terms')->where('status', true);
        return $packages->get();
    }
}
