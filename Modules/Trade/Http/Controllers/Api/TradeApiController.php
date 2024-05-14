<?php

namespace Modules\Trade\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Customer\Repositories\CustomerApiKeyRepository;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Trade\Jobs\SendTradeMarket;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Trade\Libraries\Tatum;
use Modules\Trade\Transformers\Market\DetailPairInfoTransformer;
use Modules\Trade\Transformers\Trades\TradeTransformer;
use Modules\Trade\Transformers\Markets\TickerTransformer;


class TradeApiController extends BaseApiController
{
    private $walletRepository;
    private $currencyRepository;
    private $tradeRepository;
    private $customerApiKeyRepository;
    private $marketRepository;

    public function __construct(
        WalletRepository $walletRepository,
        CurrencyRepository $currencyRepository,
        TradeRepository $tradeRepository,
        CustomerApiKeyRepository $customerApiKeyRepository,
        MarketRepository $marketRepository
    ) {
        $this->walletRepository = $walletRepository;
        $this->currencyRepository = $currencyRepository;
        $this->tradeRepository = $tradeRepository;
        $this->customerApiKeyRepository = $customerApiKeyRepository;
        $this->marketRepository = $marketRepository;
    }

    public function getBalance(Request $request)
    {
        try {
            $requestData = $request->all();
            $token = $request->header('api-key');
            /**
             * check auth = guard ('api-key')
             * check customer status
             */
            $apiKey = $this->customerApiKeyRepository->findByAttributes(['token' => $token]);
            if ($apiKey) {
                $apiKey->update(['call_count' => $apiKey->call_count + 1]);
                $customer = $apiKey->customer;
                if ($customer) {
                    $symbol = $requestData['symbol'];
                    $currency = $this->currencyRepository->findByAttributes(['code' => $symbol]);
                    if ($currency) {
                        $wallet = $this->walletRepository->findByAttributes([
                            'customer_id' => $customer->id,
                            'currency_id' => $currency->id
                        ]);
                        if ($wallet) {
                            $balance = $wallet->balance;
                            return $this->respondWithSuccess(['message' => trans('customer::customertradeapi.messages.get_balance_successfully'), 'balance' => $balance]);
                        }
                        return $this->respondWithSuccess(['message' => trans('customer::customertradeapi.messages.not_found_balance'), 'balance' => 0]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('customer::customertradeapi.messages.get_balance_failed'));
        }
    }

    public function getTicker(Request $request)
    {
        try {
            $pairs = $this->marketRepository->getListMarket($request);
            return $this->respondWithSuccess([
                'message' => trans('trade::trades.messages.get_ticker_success'),
                'tickers' => TickerTransformer::collection($pairs),
                'meta' => [
                    'current_page' => $pairs->currentPage(),
                    'per_page' => $pairs->perPage(),
                    'total' => $pairs->total(),
                    'totalPage' => ceil($pairs->total() / $pairs->perPage())
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('trade::trades.messages.not_found_ticker'));
        }
    }

    public function listOrders(Request $request)
    {
        try {
            /**
             * check auth = guard ('api-key')
             * check customer status
             */
            $requestData = $request->all();
            $token = $request->header('api-key');
            $apiKey = $this->customerApiKeyRepository->findByAttributes(['token' => $token]);
            if ($apiKey) {
                $apiKey->update(['call_count' => $apiKey->call_count + 1]);
                $customer = $apiKey->customer;

                if($customer) {
                    if (isset($requestData['symbol'])) {
                        $symbol = $this->marketRepository->findByAttributes(['symbol' => $requestData['symbol']]);
                        if(!$symbol) {
                            return $this->respondWithError(trans('customer::customertradeapi.messages.get_list_orders_failed'));
                        }
                    } else {
                        $symbol = null;
                    }
                    if (isset($requestData['type'])) {
                        $type = strtoupper($requestData['type']);
                        if($type != "BUY" && $type != "SELL") {
                            return $this->respondWithError(trans('customer::customertradeapi.messages.get_list_orders_failed'));
                        }
                    } else {
                        $type = null;
                    }
                    if (isset($requestData['status'])) {
                        $statusValue = strtoupper($requestData['status']);
                    
                        if ($statusValue == "OPEN") {
                            $status = 0;
                        } else if ($statusValue == "CLOSE") {
                            $status = 1;
                        } else {
                            return $this->respondWithError(trans('customer::customertradeapi.messages.get_list_orders_failed'));
                        }
                    } else {
                        $status = null;
                    }
                    $orders = $this->tradeRepository->getListMyOrders($customer->id, $status, $type, $symbol, $request);
                    return $this->respondWithSuccess([
                        'message' => trans('customer::customertradeapi.messages.get_list_orders_successfully'), 
                        'orders' => TradeTransformer::collection($orders),
                        'meta' => [
                            'current_page' => $orders->currentPage(),
                            'per_page' => $orders->perPage(),
                            'total' => $orders->total(),
                            'totalPage' => ceil($orders->total() / $orders->perPage())
                        ]
                    ]);
                }
            }
            return $this->respondWithError(trans('customer::customertradeapi.messages.get_list_orders_failed'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('customer::customertradeapi.messages.get_list_orders_failed'));
        }
    }

    public function cancelOrder(Request $request)
    {
        try {
            /**
             * check auth = guard ('api-key')
             * check customer status
             */
            $data = $request->all();
            $token = $request->header('api-key');
            $apiKey = $this->customerApiKeyRepository->findByAttributes(['token' => $token]);
            $customer = $apiKey->customer;
            if ($customer) {
                $trade = $this->tradeRepository->findByAttributes(['id' => $data['id'], 'status' => 0]);
                if ($trade && $trade->customer_id == $customer->id) {
                    $market = $trade->market;
                    $walletBase = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $market->currency_id]);
                    $walletQuote = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $market->currency_pair_id]);
                    if ($trade->trade_type == 'SELL' && !$walletBase) {
                        return $this->respondWithError(trans('wallet::wallets.messages.wallet_not_found'));
                    }

                    if ($trade->trade_type == 'BUY' && !$walletQuote) {
                        return $this->respondWithError(trans('wallet::wallets.messages.wallet_not_found'));
                    }
                    // if (!$walletBase || !$walletQuote) {
                    //     return $this->respondWithError(trans('trade::trades.messages.not_found'));
                    // }

                    $currency = $market->currency;
                    $currencyPair = $market->currencyPair;

                    $balance = $walletBase->balance;
                    $amount = $trade->amount - $trade->fill;
                    $price = $trade->price_was;
                    $walletId = $walletBase->id;
                    $currencyTrade = $currency;
                    if ($trade->trade_type == 'BUY') {
                        $balance = $walletQuote->balance;
                        $amount = $amount * $price;
                        $walletId = $walletQuote->id;
                        $currencyTrade = $currencyPair;
                    }
                    $tatumApiKey = setting('trade::tatum_api_key');
                    $tatum = new Tatum($tatumApiKey);
                    $tatum->deleteTrade($trade->order_id);
                    $this->tradeRepository->update($trade, ['status' => 1]);

                    $newBalance = $balance + $amount;
                    event(new UpdateBalanceWallet($newBalance, $walletId));
                    $dataCreate = [
                        'customer_id' => $customer->id,
                        'currency_id' => $currencyTrade->id,
                        'blockchain_id' => null,
                        'action' => TypeTransactionActionEnum::TRADE_RETURN,
                        'amount' => $amount,
                        'amount_usd' => $amount * $currencyTrade->usd_rate,
                        'fee' => 0,
                        'balance' => $newBalance,
                        'balanceBefore' => $balance,
                        'payment_method' => 'CRYPTO',
                        'txhash' => random_strings(30),
                        'from' => "",
                        'to' => "",
                        'tag' => null,
                        'order' => $trade->id,
                        'note' => "Admin Cancel Trade",
                        'status' => StatusTransactionEnum::COMPLETED
                    ];
                    event(new CreateTransaction($dataCreate));
                    return response()->json([
                        'errors' => false,
                        'message' => trans('trade::trades.messages.cancel_trade_success'),
                    ]);
                } else {
                    return response()->json([
                        'errors' => true,
                        'message' => trans('trade::trades.messages.not_found'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError(trans('customer::customertradeapi.messages.get_list_orders_failed'));
        }
    }

    public function createOrder(Request $request)
    {
        try {
            /**
             * check auth = guard ('api-key')
             * check customer status
             */
            $dataRequest = $request->all();
            $token = $request->header('api-key');
            $apiKey = $this->customerApiKeyRepository->findByAttributes(['token' => $token]);
            if ($apiKey) {
                $apiKey->update(['call_count' => $apiKey->call_count + 1]);
                $customer = $apiKey->customer;
                $pair = $this->marketRepository->findByAttributes(['symbol' => $dataRequest['symbol']]);

                if ($pair) {
                    if (in_array($dataRequest['type'], ['BUY', 'SELL'])) {
                        $walletBase = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $pair->currency_id]);
                        $walletQuote = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $pair->currency_pair_id]);
                        if ($dataRequest['type'] == 'SELL' && !$walletBase) {
                            return $this->respondWithError(trans('wallet::wallets.messages.wallet_not_found'));
                        }

                        if ($dataRequest['type'] == 'BUY' && !$walletQuote) {
                            return $this->respondWithError(trans('wallet::wallets.messages.wallet_not_found'));
                        }
                        $currency = $pair->currency;
                        $currencyPair = $pair->currencyPair;
                        $balance = $walletBase->balance;
                        $amount = $dataRequest['amount'];
                        $price = $dataRequest['price'];
                        $amountBase = $dataRequest['amount'];
                        $amountQuote = $dataRequest['amount'] * $price;
                        $walletId = $walletBase->id;
                        $currencyTrade = $currency;
                        if ($dataRequest['type'] == 'BUY') {
                            $balance = $walletQuote->balance;
                            $amount = $amount * $price;
                            $walletId = $walletQuote->id;
                            $currencyTrade = $currencyPair;
                        }
                        if ($amountBase < $pair->min_amount || $amountBase > $pair->max_amount) {
                            return $this->respondWithError(trans('trade::trades.messages.max_min_amount'));
                        }
                        if ($balance > $amount) {
                            $newBalance = $balance - $amount;
                            event(new UpdateBalanceWallet($newBalance, $walletId));
                            $dataTrade = [
                                'customer_id' => $customer->id,
                                'market_id' => $pair->id,
                                'amount' => $amountBase,
                                'amount_pair' => $amountQuote,
                                'price_was' => $price,
                                'total_fee' => 0,
                                'fee' => 0,
                                'fill' => 0,
                                'trade_type' => $dataRequest['type'],
                                'order_id' => null,
                                'status' => 0
                            ];

                            $pairService = $pair->service_base_code . '/' . $pair->service_quote_code;
                            $trade = $this->tradeRepository->create($dataTrade);
                            $dataCreate = [
                                'customer_id' => $customer->id,
                                'currency_id' => $currencyTrade->id,
                                'blockchain_id' => null,
                                'action' => TypeTransactionActionEnum::TRADE_OUT,
                                'amount' => $amount,
                                'amount_usd' => $amount * $currencyTrade->usd_rate,
                                'fee' => 0,
                                'balance' => $newBalance,
                                'balanceBefore' => $balance,
                                'payment_method' => 'CRYPTO',
                                'txhash' => random_strings(30),
                                'from' => "",
                                'to' => "",
                                'tag' => null,
                                'order' => $trade->id,
                                'note' => null,
                                'status' => StatusTransactionEnum::COMPLETED
                            ];
                            event(new CreateTransaction($dataCreate));
                            SendTradeMarket::dispatch($dataRequest['type'], $price, $amountBase, $pairService, $pair->service_base_id, $pair->service_quote_id, $trade->id);
                            return $this->respondWithSuccess(['message' => trans('trade::trades.messages.create_trade_success'), 'order' => $trade]);
                        } else {
                            return $this->respondWithError(trans('trade::trades.messages.balance_not_enough'));
                        }
                    } else {
                        return $this->respondWithError(trans('trade::trades.messages.type_trade_not_found'));
                    }
                } else {
                    return $this->respondWithError(trans('trade::markets.messages.pair_not_found'));
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}