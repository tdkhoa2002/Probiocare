<?php

namespace Modules\Cryperrswap\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Cryperrswap\Entities\Order;
use Modules\Cryperrswap\Http\Requests\CalExchangeRequest;
use Modules\Cryperrswap\Http\Requests\ExchangeRequest;
use Modules\Cryperrswap\Repositories\OrderRepository;
use Modules\Cryperrswap\Repositories\ServiceRepository;
use Modules\Cryperrswap\Services\FixedFloatApi;
use Modules\Cryperrswap\Repositories\CurrencyRepository;

class PublicApiController extends BaseApiController
{
    /**
     * @var Application
     */
    private $app;
    private $orderRepository;
    private $serviceRepository;
    private $currencyRepository;

    public function __construct(
        Application $app,
        OrderRepository $orderRepository,
        ServiceRepository $serviceRepository,
        CurrencyRepository $currencyRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->orderRepository = $orderRepository;
        $this->serviceRepository = $serviceRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function exchange(Request $request)
    {
        try {
            $data = $request->all();
            $validator = $this->validateExchange($request->all());
            if ($validator->fails()) {
                return $this->respondWithValidateError(trans('cryperrswap::orders.message.validate_exchange'), $validator->errors());
            }

            $service = $this->serviceRepository->getServiceActive();
            if ($service) {
                $currencyFrom = $this->currencyRepository->findByAttributes(['code' => $data['fromCcy']]);
                $currencyTo = $this->currencyRepository->findByAttributes(['code' => $data['toCcy']]);
                if (!$currencyFrom || !$currencyTo) {
                    return $this->respondWithError(trans('cryperrswap::currencies.messages.not_found'));
                }
                $type = Order::type;
                if (!in_array($data['type'], $type)) {
                    return $this->respondWithError(trans('cryperrswap::orders.messages.type_not_found'));
                }
                $dataExchange = [
                    'type' =>  $data['type'],
                    'fromCcy' =>  $data['fromCcy'],
                    'toCcy' =>  $data['toCcy'],
                    'amount' =>  $data['amount'],
                    'direction' =>  'from',
                    'toAddress' =>  $data['toAddress'],
                    'refcode' =>  'pmr6qv6c',
                    'afftax' =>  0.4,
                ];
                if ($service->afftax != null && $service->refcode != null) {
                    $dataExchange['refcode'] = $service->refcode;
                    $dataExchange['afftax'] = $service->afftax;
                }

                $fixedFloatApi = new FixedFloatApi($service->api_key, $service->serect_key);
                $order = $fixedFloatApi->create($dataExchange);
                if (isset($order)) {
                    if (isset($order['error']) && $order['error'] == true) {
                        return $this->respondWithError($order['message']);
                    } else {
                        $order_code = random_strings(10);
                        $dataCreate = [
                            'order_code' => $order_code,
                            'from_currency_id' => $currencyFrom->id,
                            'token_send' => $order['from']['amount'] ?? 0,
                            'address_order' => $order['from']['address'] ?? "",
                            'to_currency_id' => $currencyTo->id,
                            'receive_order' => $data['toAddress'],
                            'token_receive' => $order['to']['amount'] ?? 0,
                            'fee' => 0,
                            'email' => null,
                            'type' => $data['type'],
                            'order_service_id' => $order['id'],
                            'order_service_token' => $order['token'],
                            'status' => 'NEW'
                        ];
                        $this->orderRepository->create($dataCreate);
                        return $this->respondWithSuccess(['message' => trans('cryperrswap::orders.messages.create_order_success'), 'url' => route('fe.cryperrswap.order', $order_code)]);
                    }
                } else {
                    return $this->respondWithError(trans('cryperrswap::orders.messages.create_order_error'));
                }
            } else {
                return $this->respondWithError(trans('cryperrswap::services.messages.services_not_found'));
            }
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    private function validateExchange(array $data)
    {
        return Validator::make($data, [
            'type' => 'required',
            'fromCcy' => 'required',
            'toCcy' => 'required',
            'amount' => 'required',
            'toAddress' => 'required',
        ]);
    }

    private function validateCalExchangePrice(array $data)
    {
        return Validator::make($data, [
            'type' => 'required',
            'fromCcy' => 'required',
            'toCcy' => 'required',
            'amount' => 'required',
            'direction' => 'required'
        ]);
    }

    public function calExchangePrice(Request $request)
    {
        try {
            $data = $request->all();
            $validator = $this->validateCalExchangePrice($request->all());
            if ($validator->fails()) {
                return $this->respondWithValidateError(trans('cryperrswap::orders.message.validate_calExchangePrice'), $validator->errors());
            }

            $service = $this->serviceRepository->getServiceActive();
            if ($service) {
                $direction = Order::direction;
                $type = Order::type;
                if (!in_array($data['type'], $type)) {
                    return $this->respondWithError(trans('cryperrswap::orders.messages.type_not_found'));
                }
                if (!in_array($data['direction'], $direction)) {
                    return $this->respondWithError(trans('cryperrswap::orders.messages.direction_not_found'));
                }
                $dataPrice = [
                    'type' =>  $data['type'],
                    'fromCcy' =>  $data['fromCcy'],
                    'toCcy' =>  $data['toCcy'],
                    'amount' =>  $data['amount'],
                    'direction' =>  $data['direction'],
                ];
                $fixedFloatApi = new FixedFloatApi($service->api_key, $service->serect_key);
                $price = $fixedFloatApi->price($dataPrice);
                return $this->respondWithSuccess($price);
            } else {
                return $this->respondWithError(trans('cryperrswap::services.messages.services_not_found'));
            }
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getCurrency()
    {
        try {
            $service = $this->serviceRepository->getServiceActive();
            if ($service) {
                $currencies = $this->currencyRepository->getByAttributes(['service_id' => $service->id, 'status' => true]);
                return $this->respondWithSuccess($currencies);
            } else {
                return $this->respondWithError(trans('cryperrswap::services.messages.services_not_found'));
            }
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
