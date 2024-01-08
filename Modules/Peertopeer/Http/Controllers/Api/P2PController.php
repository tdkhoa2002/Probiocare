<?php

namespace Modules\Peertopeer\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Peertopeer\Repositories\OrderRepository;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Peertopeer\Transformers\Market\FullAdsInfoTransformer;
use Modules\Peertopeer\Transformers\Market\FullOrderInfoTransformer;

class P2PController extends BaseApiController
{
    private $adsRepository;
    private $orderRepository;
    public function __construct(
        AdsRepository $adsRepository,
        OrderRepository $orderRepository,
    ) {
        parent::__construct();
        $this->adsRepository = $adsRepository;
        $this->orderRepository = $orderRepository;
    }

    public function getOrders(Request $request)
    {
        return $this->respondWithData(['a' => 'q']);
    }
    public function getAds(Request $request)
    {
        $adsBuy = $this->adsRepository->where('status', 1)
            ->orderBy('id', 'desc');
        if ($request->type != "ALL") {
            $adsBuy->where('type', $request->type);
        }
        if ($request->currency != "ALL") {
            $adsBuy->where('asset_currency_id', $request->currency);
        }
        if ($request->fiat != "ALL") {
            $adsBuy->where('fiat_currency_id', $request->fiat);
        }
        $adsBuy = $adsBuy->get();
        $transformData = FullAdsInfoTransformer::collection($adsBuy);
        // dd($adsBuy);
        return $this->respondWithData($transformData);
    }

    public function getMyOrders($customerID, Request $request)
    {
        try {
            if (isset($request->status) && $request->status != "ALL") {
               $status = ($request->status == 1) ? 1 : 0;
                $attributes = ['customer_id' => $customerID, "status" => $status];
            } else {
                $attributes = ['customer_id' => $customerID];

            }
            $data = $this->orderRepository->getByAttributes($attributes, "id", "desc");
            $transformData = FullOrderInfoTransformer::collection($data);
            return $this->respondWithData($transformData);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }


}