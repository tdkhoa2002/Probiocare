<?php

namespace Modules\Staking\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Staking\Transformers\Packages\AdminPackageTransformer;
use Modules\Staking\Entities\Package;
use Modules\Staking\Http\Requests\CreatePackageRequest;
use Modules\Staking\Http\Requests\UpdatePackageRequest;
use Modules\Staking\Repositories\PackageRepository;
use Modules\Staking\Transformers\Packages\FullAdminPackageTransformer;
use Modules\Staking\Transformers\Packages\FullPackageTransformer;
use Modules\Staking\Transformers\Packages\PackageTransformer;

class PackageAdminController extends Controller
{
    /**
     * @var PackageRepository
     */
    private $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    public function indexServerSide(Request $request)
    {
        return AdminPackageTransformer::collection($this->packageRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreatePackageRequest $request)
    {
        $this->packageRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('staking::packages.messages.package created'),
        ]);
    }

    public function find($PackageId)
    {
        $Package = $this->packageRepository->find($PackageId);
        return new FullAdminPackageTransformer($Package);
    }

    public function update(Package $Package, UpdatePackageRequest $request)
    {
        $this->packageRepository->update($Package, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('staking::packages.messages.package updated'),
        ]);
    }

    public function destroy(Package $Package)
    {
        $this->packageRepository->destroy($Package);
        return response()->json([
            'errors' => false,
            'message' => trans('staking::packages.messages.package deleted'),
        ]);
    }
}
