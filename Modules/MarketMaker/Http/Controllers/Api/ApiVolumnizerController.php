<?php

namespace Modules\MarketMaker\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\MarketMaker\Repositories\VolumnizerRepository;
use Modules\Trade\Repositories\MarketRepository;
use Modules\MarketMaker\Transformers\Volumnizer\VolumnizerTransformer;
use Modules\MarketMaker\Entities\Volumnizer;

class ApiVolumnizerController extends BaseApiController
{
    private $volumnizerRepository;
    private $marketRepository;

    public function __construct(
        VolumnizerRepository $volumnizerRepository,
        MarketRepository $marketRepository
    ) {
        $this->volumnizerRepository = $volumnizerRepository;
        $this->marketRepository = $marketRepository;
    }

    public function indexServerSide(Request $request)
    {
        return VolumnizerTransformer::collection($this->volumnizerRepository->serverPaginationFilteringFor($request));
    }

    public function store(Request $request) {
        try {
            $requestData = $request->all();
            $customerId = setting('trade::customer_bot_id');
            if($customerId == null) {
                return $this->respondWithError(trans('marketmaker::volumnizers.messages.create_volumnizer_failed')); 
            }
            $pair = $this->marketRepository->find($requestData['market_id']);
            if($pair) {
                $startTime = $requestData['start_time'];
                $endTime = $requestData['end_time'];
                $amount = $requestData['amount'];
                if($startTime <= $endTime && $amount > $pair->min_amount && $amount < $pair->max_amount) {
                    $data = [
                        'market_id' => $requestData['market_id'],
                        'customer_id' => setting('trade::customer_bot_id'),
                        'amount' => $requestData['amount'],
                        'interval' => $requestData['time'],
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'checkpoint' => $startTime,
                        'status' => 1
                    ];
                    $volumnizer = $this->volumnizerRepository->create($data);
                    return $this->respondWithSuccess(['message' => trans('marketmaker::volumnizers.messages.create_volumnizer'), 'volumnizer' => $volumnizer]);
                }
            }
            return $this->respondWithError(trans('marketmaker::volumnizers.messages.create_volumnizer_failed')); 
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::volumnizers.messages.create_volumnizer_failed'));
        }
    }

    public function find(Request $request) {
        try {
            $requestData = $request->all();
            $volumnizer = $this->volumnizerRepository->find($requestData['targetprice']);
            return $this->respondWithSuccess(['message' => trans('marketmaker::volumnizers.messages.find_volumnizer'), 'volumnizer' => $volumnizer]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::volumnizers.messages.create_volumnizer_failed'));
        }
    }

    public function update(Volumnizer $volumnizer, Request $request) {
        try {
            $requestData = $request->all();
            if($volumnizer) {
                $customerId = setting('trade::customer_bot_id');
                if($customerId == null) {
                    return $this->respondWithError(trans('marketmaker::volumnizers.messages.update_volumnizer_failed')); 
                }
                $data = [
                    'market_id' => $requestData['market_id'],
                    'amount' => $requestData['amount'],
                    'interval' => $requestData['time'],
                    'start_time' => $requestData['start_time'],
                    'end_time' => $requestData['end_time'],
                    'customer_id' => setting('trade::customer_bot_id'),
                ];
                $volumnizerUpdated = $this->volumnizerRepository->update($volumnizer, $data);
                return $this->respondWithSuccess(['message' => trans('marketmaker::volumnizers.messages.update_volumnizer'), 'volumnizer' => $volumnizerUpdated]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('marketmaker::volumnizers.messages.update_volumnizer_failed'));
        }
    }

    public function delete(Volumnizer $volumnizer) {
        try {
            info($volumnizer);
            if($volumnizer) {
                $this->volumnizerRepository->destroy($volumnizer);
                return response()->json([
                    'errors' => false,
                    'message' => trans('marketmaker::volumnizers.messages.delete_volumnizer'),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errors' => true,
                'message' => trans('marketmaker::volumnizers.messages.delete_volumnizer_failed'),
            ]);
        }
    }
}
