<?php

namespace Modules\Loyalty\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Loyalty\Events\PackageIsCreating;
use Modules\Loyalty\Events\PackageWasCreated;
use Modules\Loyalty\Events\PackageIsUpdating;
use Modules\Loyalty\Events\PackageWasUpdated;
use Modules\Loyalty\Events\PackageWasDeleted;

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

                $packages->with('translations')->join('loyalty__package_translations as t', function ($join) {
                    $join->on('loyalty__packages.id', '=', 't.package_id');
                })
                    ->where('t.locale', locale())
                    ->groupBy('loyalty__packages.id')->orderBy("t.{$fields[1]}", $order);
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

    public function create($data)
    {
        event($event = new PackageIsCreating($data));
        $package = $this->model->create($event->getAttributes());
        event(new PackageWasCreated($package, $data));
        return $package;
    }

    public function update($model, $data) {
        event($event = new PackageIsUpdating($model, $data));
        $model->update($event->getAttributes());
        event(new PackageWasUpdated($model, $data));
        return $model;
    }

    public function destroy($package) {
        event(new PackageWasDeleted($package));
        return $package->delete();
    }
}
