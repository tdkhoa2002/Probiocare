<?php

namespace Modules\Cryperrswap\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cryperrswap\Entities\Service;
use Modules\Cryperrswap\Http\Requests\CreateServiceRequest;
use Modules\Cryperrswap\Http\Requests\UpdateServiceRequest;
use Modules\Cryperrswap\Repositories\ServiceRepository;
use Modules\Cryperrswap\Services\FixedFloatApi;
use Modules\Cryperrswap\Transformers\Services\FullServiceTransformer;
use Modules\Cryperrswap\Transformers\Services\ServiceTransformer;
use Modules\Cryperrswap\Transformers\Services\SmallServiceTransformer;
use Modules\Cryperrswap\Repositories\CurrencyRepository;

class ServiceController extends Controller
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;
    private $currencyRepository;

    public function __construct(ServiceRepository $serviceRepository, CurrencyRepository $currencyRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function all()
    {
        return SmallServiceTransformer::collection($this->serviceRepository->all());
    }

    public function indexServerSide(Request $request)
    {
        return ServiceTransformer::collection($this->serviceRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateServiceRequest $request)
    {
        $this->serviceRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('cryperrswap::services.messages.service created'),
        ]);
    }

    public function find($serviceId)
    {
        $service = $this->serviceRepository->find($serviceId);
        return new FullServiceTransformer($service);
    }

    public function update(Service $service, UpdateServiceRequest $request)
    {
        $this->serviceRepository->update($service, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('cryperrswap::services.messages.service updated'),
        ]);
    }

    public function destroy(Service $service)
    {
        $this->serviceRepository->destroy($service);
        return response()->json([
            'errors' => false,
            'message' => trans('cryperrswap::services.messages.service deleted'),
        ]);
    }

    public function syncAddress(Service $service)
    {
        try {
            if ($service->service_type == 'fixedfloat') {
                $fixedFloatApi = new FixedFloatApi($service->api_key, $service->serect_key);
                $currencies = $fixedFloatApi->ccies();
                if (isset($currencies) && count($currencies) > 0) {
                    foreach ($currencies as $currency) {
                        $data = [
                            'service_id' => $service->id,
                            'code' => $currency['code'],
                            'coin' => $currency['coin'],
                            'name' => $currency['name'],
                            'network' => $currency['network'],
                            'priority' => $currency['priority'],
                            'recv' => $currency['recv'],
                            'send' => $currency['send'],
                            'tag' => $currency['tag'],
                            'logo' => $currency['logo'],
                            'color' => $currency['color'],
                            'status' => true,
                        ];
                        $this->currencyRepository->updateOrCreate([
                            'service_id' => $service->id,
                            'code' => $currency['code'],
                            'coin' => $currency['coin']
                        ], $data);
                    }
                }
            } else {
                return true;
            }
        } catch (\Exception $e) {
            return response()->json([
                'errors' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
