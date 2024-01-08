<?php

namespace Modules\Peertopeer\Http\Controllers;

use Carbon\Carbon;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Customer\Repositories\PaymentMethodRepository;
use Modules\Peertopeer\Repositories\AdsRepository;
use Modules\Customer\Repositories\PaymentMethodCustomerRepository;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Peertopeer\Http\Requests\CreateOrderRequest;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Peertopeer\Jobs\JobCancelOrderBuy;
use Modules\Peertopeer\Jobs\JobCancelOrderSell;
use Modules\Peertopeer\Jobs\JobCompletedOrderSell;
use Modules\Peertopeer\Repositories\OrderRepository;
use Modules\Peertopeer\Transformers\Market\FullOrderInfoTransformer;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Peertopeer\Repositories\OrderHistoryRepository;
use Modules\Peertopeer\Transformers\Market\FullOrderAgentTransformer;

class ApiOrderController extends BaseApiController
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

    public function createOrder(CreateOrderRequest $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $ads = $this->adsRepository->findByAttributes(['status' => true, 'id' => $request->get('adsId')]);
            if ($ads && $ads->status == true) {
                if ($ads->customer_id == $customer->id) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.cant_proccess_this_ads'));
                }

                if ($ads->require_kyc == true) {
                    if ($customer->status_kyc !== 2) {
                        return $this->respondWithError(trans('peertopeer::orders.messages.ads_require_kyc'));
                    }
                }
                if ($ads->require_registered == true) {
                    $createdAt = Carbon::parse($customer->created_at);
                    $now = now();
                    if ($now->diffInDays($createdAt) < $ads->require_registered_day) {
                        return $this->respondWithError(trans('peertopeer::orders.messages.require_registered_day', ['day' => $ads->require_registered_day]));
                    }
                }
                if ($ads->require_holding == true) {
                    $asset_currency = $ads->currency;
                    $wallet = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $ads->asset_currency_id]);
                    if ($wallet) {
                        if ($wallet->balance <  $ads->require_holding_amount) {
                            return $this->respondWithError(trans('peertopeer::orders.messages.require_holding_amount', [
                                'amount' => $ads->require_holding_amount,
                                'code' => $asset_currency->code
                            ]));
                        }
                    } else {
                        return $this->respondWithError(trans('peertopeer::orders.messages.require_holding_amount', [
                            'amount' => $ads->require_holding_amount,
                            'code' => $asset_currency->code
                        ]));
                    }
                }
                if ($ads->type == 'SELL') {
                    return $this->handleBuyAds($ads, $request, $customer);
                } else {
                    return $this->handleSellAds($ads, $request, $customer);
                }
            } else {
                return $this->respondWithError(trans('peertopeer::ads.messages.ads_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    private function handleBuyAds($ads, $request, $customer)
    {
        try {
            $agent = $this->customerRepository->find($ads->customer_id);
            if ($agent) {
                $assetCurrency = $ads->currency;
                $fiatCurrency = $ads->currencyFiat;
                $total_trade_amount = $ads->total_trade_amount;
                $total_filled = $ads->total_filled;
                $amountPay = $request->get('pay');
                $amountReceive = $request->get('receive');

                if ($amountReceive > $ads->order_limit_max || $amountReceive < $ads->order_limit_min) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.order_over_limit'));
                }
                if ($total_trade_amount < ($total_filled + $amountReceive)) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.order_over_limit'));
                }

                $wallet = $this->walletRepository->findByAttributes(['customer_id' => $agent->id, 'currency_id' => $assetCurrency->id]);
                if (!$wallet) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.order_over_limit'));
                }

                if ($wallet->balance < $amountReceive) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.order_over_limit'));
                }
                $dataOrder = [
                    'code' => random_number(16),
                    'ads_id' => $ads->id,
                    'customer_id' => $customer->id,
                    'paymentmethod_id' => null,
                    'total_fiat_amount' => $amountPay,
                    'total_asset_amount' => $amountReceive,
                    'type' => 'BUY',
                    'room_id' => null,
                    'status' => 0,
                    'seller_id' => $ads->customer_id,
                    'fixed_price' => $ads->fixed_price,
                    'buyer_id' => $customer->id,
                    'fiat_currency_id' => $fiatCurrency->id,
                    'asset_currency_id' => $assetCurrency->id
                ];
                $order = $this->orderRepository->create($dataOrder);
                $newBalance = $wallet->balance - $amountReceive;
                event(new UpdateBalanceWallet($newBalance, $wallet->id));
                $this->adsRepository->update($ads, ['total_filled' => $total_filled + $amountReceive]);
                $transaction = [
                    'customer_id' => $agent->id,
                    'currency_id' => $assetCurrency->id,
                    'blockchain_id' => null,
                    'action' => TypeTransactionActionEnum::AGENT_SELL_ADS,
                    'amount' => $amountReceive,
                    'amount_usd' =>  $amountReceive * $assetCurrency->usd_rate,
                    'fee' => 0,
                    'balance' => $newBalance,
                    'balanceBefore' => $wallet->balance,
                    'payment_method' => 'P2P',
                    'txhash' => random_strings(30),
                    'from' => null,
                    'to' => null,
                    'tag' => "",
                    'order' => $order->id,
                    'note' => "",
                    'status' => StatusTransactionEnum::COMPLETED
                ];
                event(new CreateTransaction($transaction));
                return $this->respondWithSuccess(['message' => trans('peertopeer::orders.messages.create_order_success'), 'url' => route('fe.p2p.order.detail', $order->id)]);
            } else {
                return $this->respondWithError(trans('peertopeer::orders.messages.agent_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    private function handleSellAds($ads, $request, $customer)
    {
        try {
            $agent = $this->customerRepository->find($ads->customer_id);
            if ($agent) {
                $assetCurrency = $ads->currency;
                $fiatCurrency = $ads->currencyFiat;
                $total_trade_amount = $ads->total_trade_amount;
                $total_filled = $ads->total_filled;
                $amountReceive = $request->get('pay');
                $amountPay = $request->get('receive');
                $payment_method_id = $request->get('payment_method_id');

                $paymentMethodCustomer = $this->paymentMethodCustomerRepository->find($payment_method_id);
                if (!$paymentMethodCustomer) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.payment_method_not_found'));
                }

                if ($amountReceive > $ads->order_limit_max || $amountReceive < $ads->order_limit_min) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.order_over_limit'));
                }
                if ($total_trade_amount < ($total_filled + $amountReceive)) {
                    return $this->respondWithError(trans('peertopeer::orders.messages.order_over_limit'));
                }

                $wallet = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $assetCurrency->id]);
                if (!$wallet) {
                    return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                }

                if ($wallet->balance < $amountReceive) {
                    return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                }

                $dataOrder = [
                    'code' => random_strings(16),
                    'ads_id' => $ads->id,
                    'customer_id' => $customer->id,
                    'paymentmethod_id' => $payment_method_id,
                    'total_fiat_amount' => $amountPay,
                    'total_asset_amount' => $amountReceive,
                    'type' => 'SELL',
                    'room_id' => null,
                    'status' => 0,
                    'seller_id' => $ads->customer_id,
                    'fixed_price' => $ads->fixed_price,
                    'buyer_id' => $customer->id,
                    'fiat_currency_id' => $fiatCurrency->id,
                    'asset_currency_id' => $assetCurrency->id
                ];
                $order = $this->orderRepository->create($dataOrder);
                $newBalance = $wallet->balance - $amountReceive;
                event(new UpdateBalanceWallet($newBalance, $wallet->id));
                $this->adsRepository->update($ads, ['total_filled' => $total_filled + $amountReceive]);
                $transaction = [
                    'customer_id' => $agent->id,
                    'currency_id' => $assetCurrency->id,
                    'blockchain_id' => null,
                    'action' => TypeTransactionActionEnum::USER_SELL_ADS,
                    'amount' => $amountReceive,
                    'amount_usd' =>  $amountReceive * $assetCurrency->usd_rate,
                    'fee' => 0,
                    'balance' => $newBalance,
                    'balanceBefore' => $wallet->balance,
                    'payment_method' => 'P2P',
                    'txhash' => random_strings(30),
                    'from' => null,
                    'to' => null,
                    'tag' => "",
                    'order' => $order->id,
                    'note' => "",
                    'status' => StatusTransactionEnum::COMPLETED
                ];
                event(new CreateTransaction($transaction));
                return $this->respondWithSuccess(['message' => trans('peertopeer::orders.messages.create_order_success'), 'url' => route('fe.p2p.order.detail', $order->id)]);
            } else {
                return $this->respondWithError(trans('peertopeer::orders.messages.agent_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getMyOrders(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $data = $this->orderRepository->getMyOrder($customer->id, $request);
            $transformData = FullOrderInfoTransformer::collection($data);
            return $this->respondWithData($transformData);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function orderDetail($orderId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $orderId]);
            if ($order) {
                $transformData = new FullOrderInfoTransformer($order);
                return $this->respondWithData($transformData);
            } else {
                return $this->respondWithError(trans('peertopeer::orders.messages.order_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function cancelOrder($orderId, Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $orderId]);
            if ($order && $order->status !== 3 && $order->status !== 2) {
                $data = [
                    'order_id' => $order->id,
                    'customer_id' => $customer->id,
                    'paymentmethod_id' => null,
                    'amount' => $order->total_asset_amount,
                    'note' => $request->reason,
                    'admin_note' => null,
                ];
                $this->orderHistoryRepository->create($data);
                $this->orderRepository->update($order, ['status' => 3]);
                if ($order->type == 'BUY') {
                    JobCancelOrderBuy::dispatch($order)->delay(now()->addMinutes(1));
                } else {
                    JobCancelOrderSell::dispatch($order)->delay(now()->addMinutes(1));
                }
                return $this->respondWithSuccess(['message' => trans('peertopeer::orders.messages.cancel_order_success')]);
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
            $order = $this->orderRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $orderId]);
            if ($order && $order->status === 0) {
                $paymentMethod = $this->paymentMethodCustomerRepository->find($request->get('payment_method_id'));
                if ($paymentMethod) {
                    $data = [
                        'order_id' => $order->id,
                        'customer_id' => $customer->id,
                        'paymentmethod_id' =>  $paymentMethod->id,
                        'amount' => $order->total_asset_amount,
                        'note' => "transfered",
                        'admin_note' => null,
                    ];
                    $this->orderHistoryRepository->create($data);
                    $this->orderRepository->update($order, ['status' => 1, 'paymentmethod_id' => $paymentMethod->id]);
                    return $this->respondWithSuccess(['message' => trans('peertopeer::orders.messages.transfered_order_success')]);
                } else {
                    return $this->respondWithError(trans('peertopeer::orders.messages.payment_method_not_found'));
                }
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
            $order = $this->orderRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $orderId]);
            if ($order) {
                if ($order->status == 1) {
                    $data = [
                        'order_id' => $order->id,
                        'customer_id' => $customer->id,
                        'paymentmethod_id' => null,
                        'amount' => $order->total_asset_amount,
                        'note' => "User release token",
                        'admin_note' => null,
                    ];
                    $this->orderHistoryRepository->create($data);
                    $this->orderRepository->update($order, ['status' => 2]);
                    JobCompletedOrderSell::dispatch($order)->delay(now()->addMinutes(1));
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

    public function countTotalTrade(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            if ($request->has('customer_id')) {
                $customer_id = $request->get('customer_id');
            } else {
                $customer_id = $customer->id;
            }
            $to = now();
            $from = now()->subDay(30);
            $totalBuy = $this->orderRepository->countMyAllTrade($customer_id, 'BUY', 'ALL');
            $totalSell = $this->orderRepository->countMyAllTrade($customer_id, 'SELL', 'ALL');
            $totalTrade30 = $this->orderRepository->countMyAllTrade($customer_id, 'ALL', 'ALL', $from, $to);
            $totalTrade30Complete = $this->orderRepository->countMyAllTrade($customer_id, 'ALL', 2, $from, $to);
            return $this->respondWithData([
                'totalBuy' => $totalBuy,
                'totalSell' => $totalSell,
                'totalTrade30' => $totalTrade30,
                'totalTrade30Complete' => $totalTrade30Complete
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
