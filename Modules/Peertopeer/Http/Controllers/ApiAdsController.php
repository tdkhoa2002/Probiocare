<?php

namespace Modules\Peertopeer\Http\Controllers;

use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Customer\Repositories\PaymentMethodCustomerRepository;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Customer\Transformers\PaymentmethodCustomers\FrontEnd\SmallPaymentCustomerTransformer;
use Modules\Peertopeer\Http\Requests\CreateAdsRequest;
use Modules\Peertopeer\Transformers\Market\AdsInfoTransformer;
use Modules\Peertopeer\Transformers\Market\FullAdsInfoTransformer;

class ApiAdsController extends BaseApiController
{
    private $currencyRepository;
    private $paymentMethodRepository;
    private $adsRepository;
    private $paymentMethodCustomerRepository;
    public function __construct(
        CurrencyRepository $currencyRepository,
        PaymentMethodRepository $paymentMethodRepository,
        AdsRepository $adsRepository,
        PaymentMethodCustomerRepository $paymentMethodCustomerRepository
    ) {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->adsRepository = $adsRepository;
        $this->paymentMethodCustomerRepository = $paymentMethodCustomerRepository;
    }

    public function getListMyAds(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->is_agent) {
                $ads = $this->adsRepository->where('customer_id',  $customer->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
                return $this->respondWithData(FullAdsInfoTransformer::collection($ads));
            } else {
                return $this->respondWithError(trans('peertopeer::agents.messages.not_agent'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function createAds(CreateAdsRequest $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->is_agent) {
                $data = [
                    'customer_id' => $customer->id,
                    'fiat_currency_id' => $request->get('fiat_currency_id'),
                    'asset_currency_id' => $request->get('asset_currency_id'),
                    'fixed_price' => $request->get('fixed_price'),
                    'total_trade_amount' => $request->get('total_trade_amount'),
                    'order_limit_min' => $request->get('order_limit_min'),
                    'order_limit_max' => $request->get('order_limit_max'),
                    'payment_time_limit' => $request->get('payment_time_limit'),
                    'type' => $request->get('type'),
                    'term' => $request->get('term'),
                    'auto_reply' => $request->get('auto_reply'),
                    'status' => $request->get('status'),
                    'require_kyc' => $request->get('require_kyc'),
                    'require_registered' => $request->get('require_registered'),
                    'require_registered_day' => $request->get('require_registered_day'),
                    'require_holding' => $request->get('require_holding'),
                    'require_holding_amount' => $request->get('require_holding_amount')
                ];
                $ads = $this->adsRepository->create($data);
                $ads->paymentMethods()->sync($request->paymentMethod);
                return $this->respondWithSuccess(['message' => trans('peertopeer::ads.messages.create_ads_success'), 'url' => route('fe.p2p.market.center')]);
            } else {
                return $this->respondWithError(trans('peertopeer::agents.messages.not_agent'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function findAds($adsId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->is_agent) {
                $ads = $this->adsRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $adsId]);
                return $this->respondWithData(new AdsInfoTransformer($ads));
            } else {
                return $this->respondWithError(trans('peertopeer::agents.messages.not_agent'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function findOrderAds($adsId)
    {
        try {
            $ads = $this->adsRepository->findByAttributes(['id' => $adsId, 'status' => true]);
            if ($ads) {
                return $this->respondWithData(new AdsInfoTransformer($ads));
            } else {
                return $this->respondWithError(trans('peertopeer::ads.messages.ads_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function update($adsId, CreateAdsRequest $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->is_agent) {
                $ads = $this->adsRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $adsId]);
                if ($ads) {
                    $data = [
                        'customer_id' => $customer->id,
                        'fiat_currency_id' => $request->get('fiat_currency_id'),
                        'asset_currency_id' => $request->get('asset_currency_id'),
                        'fixed_price' => $request->get('fixed_price'),
                        'total_trade_amount' => $request->get('total_trade_amount'),
                        'order_limit_min' => $request->get('order_limit_min'),
                        'order_limit_max' => $request->get('order_limit_max'),
                        'payment_time_limit' => $request->get('payment_time_limit'),
                        'type' => $request->get('type'),
                        'term' => $request->get('term'),
                        'auto_reply' => $request->get('auto_reply'),
                        'status' => $request->get('status'),
                        'require_kyc' => $request->get('require_kyc'),
                        'require_registered' => $request->get('require_registered'),
                        'require_registered_day' => $request->get('require_registered_day'),
                        'require_holding' => $request->get('require_holding'),
                        'require_holding_amount' => $request->get('require_holding_amount')
                    ];
                    $this->adsRepository->update($ads, $data);
                    $ads->paymentMethods()->sync($request->paymentMethod);
                    return $this->respondWithSuccess(['message' => trans('peertopeer::ads.messages.update_ads_success'), 'url' => route('fe.p2p.market.center') . "#postAds"]);
                } else {
                    return $this->respondWithError(trans('peertopeer::ads.messages.ads_not_found'));
                }
            } else {
                return $this->respondWithError(trans('peertopeer::agents.messages.not_agent'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function deleteAds($adsId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($customer->is_agent) {
                $ads = $this->adsRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $adsId]);
                $this->adsRepository->destroy($ads);
                return $this->respondWithSuccess(['message' => trans('peertopeer::ads.messages.delete_ads_success'), 'url' => route('fe.p2p.market.center') . "#postAds"]);
            } else {
                return $this->respondWithError(trans('peertopeer::agents.messages.not_agent'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }


    public function getPaymentMethodAvaliable($adsId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $ads = $this->adsRepository->findByAttributes(['status' => true, 'id' => $adsId]);
            if ($ads) {
                $adsPaymentMethods = $ads->paymentMethods->pluck('paymentmethod_id')->toArray();
                $customerPaymentMethods = $customer->paymentMethods()->whereIn('paymentmethod_customers.paymentmethod_id', $adsPaymentMethods)->get();
                return $this->respondWithSuccess(SmallPaymentCustomerTransformer::collection($customerPaymentMethods));
            } else {
                return $this->respondWithError(trans('peertopeer::ads.messages.ads_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
