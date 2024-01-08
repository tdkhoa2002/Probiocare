<?php

namespace Modules\Staking\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Staking\Transformers\Commissions\AdminCommissionTransformer;
use Modules\Staking\Entities\Commission;
use Modules\Staking\Http\Requests\CreateCommissionRequest;
use Modules\Staking\Http\Requests\CreateQuickCommissionRequest;
use Modules\Staking\Http\Requests\UpdateCommissionRequest;
use Modules\Staking\Repositories\CommissionRepository;
use Modules\Staking\Transformers\Commissions\FullAdminCommissionTransformer;
use Modules\Staking\Repositories\PackageRepository;

class CommissionAdminController extends Controller
{
    /**
     * @var CommissionRepository
     */
    private $commissionRepository;
    private $packageRepository;

    public function __construct(CommissionRepository $commissionRepository, PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
        $this->commissionRepository = $commissionRepository;
    }

    public function indexServerSide($packageId)
    {
        $commission = $this->commissionRepository->getCommissionLastLevel($packageId);
        return ['commissions' => AdminCommissionTransformer::collection($this->commissionRepository->getByAttributes(['package_id' => $packageId], 'level', 'DESC')), 'commission' => $commission];
    }

    public function quickStore($packageId, CreateQuickCommissionRequest $request)
    {
        $package = $this->packageRepository->find($packageId);
        if ($package) {
            $floors = $request->get('floors');
            $commission = $this->commissionRepository->getCommissionLastLevel($packageId);
            $i = 0;
            if ($commission) {
                $i = $commission->level + 1;
            }

            for ($k = $i; $k < $floors + $i; $k++) {
                $dataCreate = [
                    'package_id' => $package->id,
                    'level' => $k,
                    'commission' => $request->get('commission'),
                    'type' => $request->get('type'),
                    'status' => false
                ];
                $this->commissionRepository->create($dataCreate);
            }
            return response()->json([
                'errors' => false,
                'message' => trans('staking::commissions.messages.commission created'),
            ]);
        } else {
            return response()->json([
                'errors' => false,
                'message' => trans('staking::packages.messages.package_not_found'),
            ]);
        }
    }


    public function store($packageId, CreateCommissionRequest $request)
    {
        $data = $request->all();
        $package = $this->packageRepository->find($packageId);
        if ($package) {
            $commission = $this->commissionRepository->getCommissionLastLevel($packageId);
            $data['package_id'] = $packageId;
            $data['level'] =   $commission ? $commission->level + 1 : 0;
            $this->commissionRepository->create($data);

            return response()->json([
                'errors' => false,
                'message' => trans('staking::commissions.messages.commission created'),
            ]);
        } else {
            return response()->json([
                'errors' => true,
                'message' => trans('staking::packages.messages.package_not_found'),
            ]);
        }
    }

    public function find($commissionId)
    {
        $commission = $this->commissionRepository->find($commissionId);
        return new FullAdminCommissionTransformer($commission);
    }

    public function update($commissionId, UpdateCommissionRequest $request)
    {
        $commission = $this->commissionRepository->find($commissionId);
        $this->commissionRepository->update($commission, ['commission' => $request->get('commission'), 'type' => $request->get('type'), 'status' => $request->get('status')]);
        return response()->json([
            'errors' => false,
            'message' => trans('staking::commissions.messages.commission updated'),
        ]);
    }

    public function destroy(Commission $commission)
    {
        $commissionLast = $this->commissionRepository->getCommissionLastLevel($commission->package_id);
        if($commission->id == $commissionLast->id){
            $this->commissionRepository->destroy($commission);
            return response()->json([
                'errors' => false,
                'message' => trans('staking::commissions.messages.commission deleted'),
            ]);
        }else {
            return response()->json([
                'errors' => true,
                'message' => trans('staking::packages.messages.cant_destroy_commission'),
            ]);
        }
    }
}
