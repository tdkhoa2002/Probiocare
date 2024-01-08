<?php
namespace Modules\MarketMaker\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\MarketMaker\Repositories\TargetPriceRepository;
use Modules\Setting\Repositories\SettingRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Trade\Repositories\MarketRepository;
use Modules\MarketMaker\Transformers\TargetPrice\TargetPriceTransformer;
use Modules\MarketMaker\Entities\TargetPrice;
use Carbon\Carbon;

class ApiTargetPriceController extends BaseApiController
{   
    private $targetPriceRepository;
    private $settingRepository;
    private $customerRepository;
    private $marketRepository;
    

    public function __construct(
        TargetPriceRepository $targetPriceRepository,
        SettingRepository $settingRepository,
        CustomerRepository $customerRepository,
        MarketRepository $marketRepository
    ) {
        $this->targetPriceRepository = $targetPriceRepository;
        $this->settingRepository = $settingRepository;
        $this->customerRepository = $customerRepository;
        $this->marketRepository = $marketRepository;
    }
    public function indexServerSide(Request $request)
    {
        return TargetPriceTransformer::collection($this->targetPriceRepository->serverPaginationFilteringFor($request));
    }

    public function find(TargetPrice $targetprice)
    {
        try {
            if($targetprice) {
                return $this->respondWithSuccess([
                    'message' => trans('trade::targetprices.messages.find_targetprice'), 
                    'targetprice' => new TargetPriceTransformer($targetprice)
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::targetprices.messages.find_targetprice_failed'));
        }
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $customerId = setting('trade::customer_bot_id');
            if($customerId == null) {
                return $this->respondWithError(trans('marketmaker::targetprices.messages.create_targetprice_failed')); 
            }
            $pair = $this->marketRepository->find($requestData['market_id']);
            if($pair) {
                $data = [
                    'price' => $requestData['price'],
                    'market_id' => $requestData['market_id'],
                    'customer_id' => setting('trade::customer_bot_id'),
                    'schedule' => $requestData['schedule'],
                    'status' => $requestData['status'],
                    'amount' => rand($pair->min_amount, $pair->max_amount)
                ];
                $targetPrice = $this->targetPriceRepository->create($data);
                return $this->respondWithSuccess(['message' => trans('marketmaker::targetprices.messages.create_targetprice'), 'targetprice' => $targetPrice]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::targetprices.messages.create_targetprice_failed'));
        }
    }

    public function update(TargetPrice $targetprice, Request $request) {
        try {
            $requestData = $request->all();
            if($targetprice) {
                $customerId = setting('trade::customer_bot_id');
                if($customerId == null) {
                    return $this->respondWithError(trans('marketmaker::targetprices.messages.create_targetprice_failed')); 
                }
                $data = [
                    'price' => $requestData['price'],
                    'market_id' => $requestData['market_id'],
                    'customer_id' => $customerId,
                    'schedule' => $requestData['schedule'],
                    'amount' => rand(100, 10000)
                ];
                $targetPriceUpdated = $this->targetPriceRepository->update($targetprice, $data);
                return $this->respondWithSuccess(['message' => trans('marketmaker::targetprices.messages.update_targetprice'), 'targetprice' => $targetPriceUpdated]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::targetprices.messages.update_targetprice_failed'));
        }
    }

    public function delete(TargetPrice $targetprice) {
        try {
            if($targetprice) {
                $this->targetPriceRepository->destroy($targetprice);
                return response()->json([
                    'errors' => false,
                    'message' => trans('marketmaker::targetprices.messages.delete_targetprice'),
                ]);
            }
            return response()->json([
                'errors' => true,
                'message' => trans('marketmaker::targetprices.messages.delete_targetprice_failed'),
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errors' => true,
                'message' => trans('marketmaker::targetprices.messages.delete_targetprice_failed'),
            ]);
        }
    }

    public function getSettingCustomerBot()
    {
        try {
            $customer = $this->customerRepository->find(setting('trade::customer_bot_id'));
            if($customer) {
                return $this->respondWithSuccess(['message' => trans('marketmaker::targetprices.messages.get_customer_bot'), 'customer' => $customer]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::targetprices.messages.get_customer_bot_failed'));
        }
    }

    public function saveSettingCustomerBot(Request $request)
    {
        try {
            $requestData = $request->all();
            $this->settingRepository->createOrUpdate([
                'trade::customer_bot_id' => $requestData['customer_id']
            ]);
            return $this->respondWithSuccess(['message' => trans('marketmaker::targetprices.messages.save_customer_bot')]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::customertradeapi.messages.save_customer_bot_failed'));
        }
    }
}