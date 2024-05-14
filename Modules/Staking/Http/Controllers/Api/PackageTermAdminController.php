<?php

namespace Modules\Staking\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Staking\Transformers\PackageTerms\AdminPackageTermTransformer;
use Modules\Staking\Entities\PackageTerm;
use Modules\Staking\Http\Requests\CreatePackageTermRequest;
use Modules\Staking\Http\Requests\UpdatePackageTermRequest;
use Modules\Staking\Repositories\PackageTermRepository;
use Modules\Staking\Transformers\PackageTerms\FullAdminPackageTermTransformer;
use Modules\Staking\Repositories\PackageRepository;

class PackageTermAdminController extends Controller
{
    /**
     * @var PackageTermRepository
     */
    private $packageTermRepository;
    private $packageRepository;

    public function __construct(PackageTermRepository $packageTermRepository, PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
        $this->packageTermRepository = $packageTermRepository;
    }

    public function indexServerSide($packageId)
    {
        return AdminPackageTermTransformer::collection($this->packageTermRepository->getByAttributes(['package_id' => $packageId]));
    }

    public function store($packageId, CreatePackageTermRequest $request)
    {
        $data = $request->all();
        $package = $this->packageRepository->find($packageId);
        if ($package) {
            $data['package_id'] = $packageId;
            $this->packageTermRepository->create($data);

            return response()->json([
                'errors' => false,
                'message' => trans('staking::packageterms.messages.packageterm created'),
            ]);
        } else {
            return response()->json([
                'errors' => false,
                'message' => trans('staking::packages.messages.package_not_found'),
            ]);
        }
    }

    public function find($packagetermId)
    {
        $PackageTerm = $this->packageTermRepository->find($packagetermId);
        return new FullAdminPackageTermTransformer($PackageTerm);
    }

    public function update($packageTermId, UpdatePackageTermRequest $request)
    {
        $packageTerm = $this->packageTermRepository->find($packageTermId);
        $this->packageTermRepository->update($packageTerm, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('staking::packageterms.messages.packageterm updated'),
        ]);
    }

    public function destroy(PackageTerm $PackageTerm)
    {
        $this->packageTermRepository->destroy($PackageTerm);
        return response()->json([
            'errors' => false,
            'message' => trans('staking::packageterms.messages.packageterm deleted'),
        ]);
    }
}
