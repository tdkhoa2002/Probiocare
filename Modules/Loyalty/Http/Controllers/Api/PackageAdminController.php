<?php

namespace Modules\Loyalty\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Loyalty\Transformers\Packages\AdminPackageTransformer;
use Modules\Loyalty\Entities\Package;


class PackageAdminController extends Controller
{
    private $packageRepository;

    public function __construct(PackageRepository $packageRepository) {
        $this->packageRepository = $packageRepository;
    }

    public function indexServerSide(Request $request) {
        return AdminPackageTransformer::collection($this->packageRepository->serverPaginationFilteringFor($request));
    }

    public function store(Request $request) {
        $packageRepository->create($request->all());
        return $this->respondWithSuccess(['message' => trans('loyalty::packages.messages.create_package')]);
    }

    public function find(Package $package) {
        try {
            if($package) {
                return $this->respondWithSuccess([
                    'message' => trans('loyalty::packages.messages.find_package'), 
                    'package' => new AdminPackageTransformer($package)
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('loyalty::packages.messages.find_package_failed'));
        }
    }

    public function update(Package $package, Request $request) {
        try {
            $requestData = $request->all();
            if($package) {
                $data = [
                    'name' => $requestData['name'],
                    'cashback' => $requestData['cashback'],
                    'reward' => $requestData['reward'],
                    'day_reward' => $requestData['day_reward'],
                    'term_matching' => $requestData['term_matching'],
                    'status' => $requestData['status']
                ];
                $packageUpdated = $this->packageRepository->update($package, $data);
                return $this->respondWithSuccess(['message' => trans('loyalty::packages.messages.update_package'), 'package' => $packageUpdated]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('loyalty::packages.messages.update_package_failed'));
        }
    }

    public function destroy(Package $package) {
        try {
            if($package) {
                $this->packageRepository->destroy($package);
                return response()->json([
                    'errors' => false,
                    'message' => trans('loyalty::packages.messages.delete_package'),
                ]);
            }
            return response()->json([
                'errors' => true,
                'message' => trans('loyalty::packages.messages.delete_package_failed'),
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errors' => true,
                'message' => trans('loyalty::packages.messages.delete_package_failed'),
            ]);
        }
    }
}
