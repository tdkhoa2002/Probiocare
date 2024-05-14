<?php

namespace Modules\Trade\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Trade\Jobs\SendTradeMarket;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Trade\Libraries\Tatum;
use Modules\Trade\Transformers\Market\DetailPairInfoTransformer;

class PublicApiController extends BaseApiController
{
    /**
     * @var Application
     */
    private $app;
    private $marketRepository;
    private $walletRepository;
    private $currencyRepository;
    private $tradeRepository;

    public function __construct(
        Application $app,
        MarketRepository $marketRepository,
        WalletRepository $walletRepository,
        CurrencyRepository $currencyRepository,
        TradeRepository $tradeRepository

    ) {
        parent::__construct();
        $this->app = $app;
        $this->marketRepository = $marketRepository;
        $this->walletRepository = $walletRepository;
        $this->currencyRepository = $currencyRepository;
        $this->tradeRepository = $tradeRepository;
    }

    public function getBalanceTrade($symbol)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $pair = $this->marketRepository->findByAttributes(['symbol' => $symbol]);
            $dataBalance = ['base' => 0, 'quote' => 0];
            if ($pair) {
                $walletBase = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $pair->currency_id]);
                $walletQuote = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $pair->currency_pair_id]);

                if ($walletBase) {
                    $dataBalance['base'] = $walletBase->balance;
                }

                if ($walletQuote) {
                    $dataBalance['quote'] = $walletQuote->balance;
                }
            }
            return $this->respondWithData($dataBalance);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function trade(Request $request)
    {
        try {
            $dataRequest = $request->all();
            $customer = auth()->guard('customer')->user();
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
                            'order' =>  $trade->id,
                            'note' => null,
                            'status' => StatusTransactionEnum::COMPLETED
                        ];
                        event(new CreateTransaction($dataCreate));
                        SendTradeMarket::dispatch($dataRequest['type'], $price, $amountBase, $pairService, $pair->service_base_id, $pair->service_quote_id, $trade->id);
                        return $this->respondWithSuccess(['message' => trans('trade::trades.messages.create_trade_success')]);
                    } else {
                        return $this->respondWithError(trans('trade::trades.messages.balance_not_enough'));
                    }
                } else {
                    return $this->respondWithError(trans('trade::trades.messages.type_trade_not_found'));
                }
            } else {
                return $this->respondWithError(trans('trade::markets.messages.pair_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function cancelTrade($tradeId)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $trade = $this->tradeRepository->findByAttributes(['id' => $tradeId, 'status' => 0, 'customer_id' => $customer->id]);
            if ($trade) {
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
                //     return $this->respondWithError(trans('wallet::wallets.messages.wallet_not_found'));
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
                    'order' =>  $trade->id,
                    'note' => null,
                    'status' => StatusTransactionEnum::COMPLETED
                ];
                event(new CreateTransaction($dataCreate));
                return $this->respondWithSuccess(['message' => trans('trade::trades.messages.cancel_trade_success')]);
            } else {
                return $this->respondWithError(trans('trade::trades.messages.not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getListMarket(Request $request)
    {
        try {
            $markets = $this->marketRepository->getListMarket($request);
            return $this->respondWithData([
                'markets' => DetailPairInfoTransformer::collection($markets),
                'meta' => [
                    'current_page' => $markets->currentPage(),
                    'per_page' => $markets->perPage(),
                    'total' => $markets->total(),
                    'totalPage' => ceil($markets->total() / $markets->perPage())
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getMyTrades($symbol)
    {
        try {
            $marketPair = $this->marketRepository->findByAttributes(['symbol' => $symbol]);
            if ($marketPair) {
                $customer = auth()->guard('customer')->user();
                $trades = $this->tradeRepository->where('customer_id',  $customer->id)
                    ->where('market_id', $marketPair->id)
                    ->orderBy('id', 'desc')
                    ->get();
                return $this->respondWithData($trades);
            } else {
                return $this->respondWithError(trans('trade::markets.messages.pair_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function countTotalTrade()
    {
        try {
            $customer = auth()->guard('customer')->user();
            $to = now();
            $from = now()->subDay(30);
            $totalBuy = $this->tradeRepository->countMyAllTrade($customer->id, 'BUY', 'ALL');
            $totalSell = $this->tradeRepository->countMyAllTrade($customer->id, 'SELL', 'ALL');
            $totalTrade30 = $this->tradeRepository->countMyAllTrade($customer->id, 'ALL', 'ALL', $from, $to);
            $totalTrade30Complete = $this->tradeRepository->countMyAllTrade($customer->id, 'ALL', 2, $from, $to);
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
