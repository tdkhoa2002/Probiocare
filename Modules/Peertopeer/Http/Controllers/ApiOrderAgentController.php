<?php

namespace Modules\Peertopeer\Http\Controllers;

use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Customer\Repositories\PaymentMethodCustomerRepository;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Peertopeer\Http\Requests\CreateOrderRequest;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Peertopeer\Jobs\JobCancelOrderBuy;
use Modules\Peertopeer\Jobs\JobCompletedOrderBuy;
use Modules\Peertopeer\Repositories\OrderRepository;
use Modules\Peertopeer\Transformers\Market\FullOrderInfoTransformer;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Peertopeer\Repositories\OrderHistoryRepository;
use Modules\Peertopeer\Transformers\Market\FullOrderAgentTransformer;

class ApiOrderAgentController extends BaseApiController
{
    private $currencyRepository;
    private $paymentMethodRepository;
    private $adsRepository;
    private $paymentMethodCustomerRepository;
    private $customerRepository;
    private $walletRepository;
    private $orderRepository;
    private $orderHistoryRepository;

    public function __construct(
        CurrencyRepository $currencyRepository,
        PaymentMethodRepository $paymentMethodRepository,
        AdsRepository $adsRepository,
        PaymentMethodCustomerRepository $paymentMethodCustomerRepository,
        CustomerRepository $customerRepository,
        WalletRepository $walletRepository,
        OrderRepository $orderRepository,
        OrderHistoryRepository $orderHistoryRepository
    ) {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->adsRepository = $adsRepository;
        $this->paymentMethodCustomerRepository = $paymentMethodCustomerRepository;
        $this->customerRepository = $customerRepository;
        $this->walletRepository = $walletRepository;
        $this->orderRepository = $orderRepository;
        $this->orderHistoryRepository = $orderHistoryRepository;
    }



    public function getAgentOrder(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $data = $this->orderRepository->getAgentOrders($customer->id, $request);
            $transformData = FullOrderAgentTransformer::collection($data);
            return $this->respondWithData($transformData);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function orderAgentDetail($orderId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findOrderAgent($orderId, $customer->id);
            if ($order) {
                $transformData = new FullOrderAgentTransformer($order);
                return $this->respondWithData($transformData);
            } else {
                return $this->respondWithError(trans('peertopeer::orders.messages.order_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function paymentReceived($orderId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findOrderAgent($orderId, $customer->id);
            if ($order) {
                if ($order->status == 1) {
                    $data = [
                        'order_id' => $order->id,
                        'customer_id' => $customer->id,
                        'paymentmethod_id' => null,
                        'amount' => $order->total_asset_amount,
                        'note' => "Agent release token",
                        'admin_note' => null,
                    ];
                    $this->orderHistoryRepository->create($data);
                    $this->orderRepository->update($order, ['status' => 2]);
                    JobCompletedOrderBuy::dispatch($order)->delay(now()->addMinutes(1));
                    return $this->respondWithSuccess(['message' => trans('peertopeer::orders.messages.payment_received_order_success')]);
                } else {
                    return $this->respondWithError(trans('peertopeer::orders.messages.order_cant_proccess'));
                }
            } else {
                return $this->respondWithError(trans('peertopeer::orders.messages.order_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function transfered($orderId, Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findOrderAgent($orderId, $customer->id);
            if ($order && $order->status === 0) {
                $data = [
                    'order_id' => $order->id,
                    'customer_id' => $customer->id,
                    'paymentmethod_id' =>  $order->paymentmethod_id,
                    'amount' => $order->total_asset_amount,
                    'note' => "transfered",
                    'admin_note' => null,
                ];
                $this->orderHistoryRepository->create($data);
                $this->orderRepository->update($order, ['status' => 1]);
                return $this->respondWithSuccess(['message' => trans('peertopeer::orders.messages.transfered_order_success')]);
            } else {
                return $this->respondWithError(trans('peertopeer::orders.messages.order_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
