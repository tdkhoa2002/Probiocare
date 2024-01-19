<?php

namespace Modules\Loyalty\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Loyalty\Transformers\Packages\AdminPackageTransformer;
use Modules\Loyalty\Entities\Package;
use Modules\Loyalty\Http\Requests\CreatePackageRequest;
use Modules\Loyalty\Http\Requests\UpdatePackageRequest;
use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Loyalty\Transformers\Packages\FullAdminPackageTransformer;
use Modules\Loyalty\Transformers\Packages\FullPackageTransformer;
use Modules\Loyalty\Transformers\Packages\PackageTransformer;

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

    public function find($packageId)
    {
        $Package = $this->packageRepository->find($packageId);
        return new FullAdminPackageTransformer($Package);
    }

    public function update(Package $packageLoyalty, UpdatePackageRequest $request)
    {
        $this->packageRepository->update($packageLoyalty, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('staking::packages.messages.package updated'),
        ]);
    }

    public function destroy(Package $packageLoyalty)
    {
        $this->packageRepository->destroy($packageLoyalty);
        return response()->json([
            'errors' => false,
            'message' => trans('staking::packages.messages.package deleted'),
        ]);
    }
}
