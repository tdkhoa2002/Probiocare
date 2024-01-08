<?php

namespace Modules\Trade\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Trade\Events\HookTradeMarket;
use Modules\Trade\Jobs\SendTradeMarket;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Trade\Repositories\TradeHistoryRepository;
use Carbon\Carbon;
use Modules\Trade\Events\HookMarketInfo;
use Modules\Trade\Events\PeertopeerChat;

class WebhookController extends BaseApiController
{
    /**
     * @var Application
     */
    private $app;
    private $marketRepository;
    private $walletRepository;
    private $currencyRepository;
    private $tradeRepository;
    private $tradeHistoryRepository;

    public function __construct(
        Application $app,
        MarketRepository $marketRepository,
        WalletRepository $walletRepository,
        CurrencyRepository $currencyRepository,
        TradeRepository $tradeRepository,
        TradeHistoryRepository $tradeHistoryRepository

    ) {
        parent::__construct();
        $this->app = $app;
        $this->marketRepository = $marketRepository;
        $this->walletRepository = $walletRepository;
        $this->currencyRepository = $currencyRepository;
        $this->tradeRepository = $tradeRepository;
        $this->tradeHistoryRepository = $tradeHistoryRepository;
    }

    public function handleTrade(Request $request)
    {
        try {
            $dataRequest = $request->all();
            \Log::channel('trade_hook')->info($dataRequest);
            sleep(2);
            if (isset($dataRequest['subscriptionType'])) {
                if ($dataRequest['subscriptionType'] == 'CUSTOMER_PARTIAL_TRADE_MATCH') {
                    return $this->handlePartialTradeMatch($dataRequest);
                }
                if ($dataRequest['subscriptionType'] == 'CUSTOMER_TRADE_MATCH') {
                    return $this->handleTradeMatch($dataRequest);
                }
            } else {
                \Log::channel('trade_hook')->info($dataRequest);
                return false;
            }
        } catch (\Exception $e) {
            \Log::channel('trade_hook')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    private function handlePartialTradeMatch($data)
    {
        $trade = $this->tradeRepository->findByAttributes(['order_id' => $data['id'], 'status' => 0]);
        if ($trade) {

            $market = $this->marketRepository->find($trade->market_id);
            $fee_percent = $market->taker;
            $wallet = $this->walletRepository->findByAttributes(['customer_id' => $trade->customer_id, 'currency_id' => $market->currency_id]);
            $amount = $data['amount'];
            $amountPair =  $data['amount'] * $trade->price_was;
            $currency = $market->currency;

            if ($data['isMaker'] == true) {
                $fee_percent = $market->maker;
            }

            if ($trade->trade_type == 'SELL') {
                $wallet = $this->walletRepository->findByAttributes(['customer_id' => $trade->customer_id, 'currency_id' => $market->currency_pair_id]);
                $amount = $amount * $trade->price_was;
                $currency = $market->currencyPair;
            }
            $fee = ($amount * $fee_percent) / 100;
            $balance = $wallet->balance;
            $newBalance = $balance + $amount - $fee;
            $this->tradeRepository->update($trade, ['fill' => $data['amount'], 'fee' => $fee, 'total_fee' => $trade->total_fee + $fee]);
            $dataCreate = [
                'customer_id' => $trade->customer_id,
                'currency_id' => $currency->id,
                'blockchain_id' => null,
                'action' => TypeTransactionActionEnum::TRADE_IN,
                'amount' => $amount,
                'amount_usd' => $amount * $currency->usd_rate,
                'fee' => $fee,
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
            $dataHis = [
                'trade_id' => $trade->id,
                'amount' => $data['amount'],
                'amount_pair' =>  $amountPair,
                'price' => $data['price'],
                'fee' => $fee,
                'fill' => $data['amount'],
                'trade_type' => $trade->trade_type,
                'is_maker' => $data['isMaker'],
                'created_at' => Carbon::now()->toDateTimeString(),
            ];
            $this->tradeHistoryRepository->create($dataHis);
            $this->calDataPair($market, $dataHis);
            event(new UpdateBalanceWallet($newBalance, $wallet->id));
            return true;
        } else {
            return false;
        }
    }

    private function handleTradeMatch($data)
    {
        try {
            $trade = $this->tradeRepository->findByAttributes(['order_id' => $data['id'], 'status' => 0]);
            if ($trade) {
                $market = $this->marketRepository->find($trade->market_id);
                $fee_percent = $market->taker;
                $wallet = $this->walletRepository->findByAttributes(['customer_id' => $trade->customer_id, 'currency_id' => $market->currency_id]);
                $amount = $trade->amount;
                $amountPair = $trade->amount_pair;
                $currency = $market->currency;

                if ($data['isMaker'] == true) {
                    $fee_percent = $market->maker;
                }

                if ($trade->trade_type == 'SELL') {
                    $wallet = $this->walletRepository->findByAttributes(['customer_id' => $trade->customer_id, 'currency_id' => $market->currency_pair_id]);
                    if (!$wallet) {
                        $dataCreate = [
                            'customer_id' =>  $trade->customer_id,
                            'currency_id' => $market->currency_pair_id,
                            'type' => 'CRYPTO',
                            'balance' => 0,
                            'status' => true,
                        ];
                        $wallet = $this->walletRepository->create($dataCreate);
                    }
                    $amount = $trade->amount * $trade->price_was;
                    $currency = $market->currencyPair;
                }
                $fee = ($amount * $fee_percent) / 100;
                $balance = $wallet->balance;
                $newBalance = $balance + $amount - $fee;
                $this->tradeRepository->update($trade, ['status' => 2, 'fill' => $trade->amount, 'fee' => $fee, 'total_fee' => $trade->total_fee + $fee]);
                $dataCreate = [
                    'customer_id' => $trade->customer_id,
                    'currency_id' => $currency->id,
                    'blockchain_id' => null,
                    'action' => TypeTransactionActionEnum::TRADE_IN,
                    'amount' => $amount,
                    'amount_usd' => $amount * $currency->usd_rate,
                    'fee' => $fee,
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
                $dataHis = [
                    'trade_id' => $trade->id,
                    'amount' => $data['amount'],
                    'amount_pair' =>  $amountPair,
                    'price' => $data['price'],
                    'fee' => $fee,
                    'fill' => $data['amount'],
                    'trade_type' => $trade->trade_type,
                    'is_maker' => $data['isMaker'],
                    'created_at' => Carbon::now()->toDateTimeString(),
                ];
                $this->tradeHistoryRepository->create($dataHis);
                $this->calDataPair($market, $dataHis);
                event(new UpdateBalanceWallet($newBalance, $wallet->id));
                return true;
            } else {
                \Log::channel('trade_hook')->error('Trade order not found order id:' . $data['id']);
                return false;
            }
        } catch (\Exception $e) {
            \Log::channel('trade_hook')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    private function calDataPair($market, $dataHis)
    {
        try {
            $dataPrice = $dataHis['price'];
            $currency = $market->currency;
            $currencyPair = $market->currencyPair;
            $price = $currencyPair->usd_rate * $dataPrice;
            $tradeHistories24H = $this->tradeHistoryRepository->getTradeHistory24H($market->id);
            if ($tradeHistories24H->count() > 0) {
                $priceChange = 0;
                $hight_24h = $tradeHistories24H->first()->price;
                $low_24h = $tradeHistories24H->last()->price;

                if ($dataPrice < $hight_24h || $dataPrice < $low_24h) {
                    $priceChange = $dataPrice - $hight_24h;
                } else if ($dataPrice >= $hight_24h) {
                    $priceChange = $dataPrice - $low_24h;
                }

                $dataUpdate = [
                    'price' => $dataPrice,
                    'price_usd' => $price,
                    'price_change_24h' => $priceChange,
                    'hight_24h' => $hight_24h,
                    'low_24h' => $low_24h,
                    'volume_24h' =>  $tradeHistories24H->sum('amount'),
                    'volume_pair_24h' =>  $tradeHistories24H->sum('amount_pair'),
                ];
            } else {
                $dataUpdate = [
                    'price' => $dataPrice,
                    'price_usd' => $price,
                    'price_change_24h' => 0,
                    'hight_24h' => $market->price,
                    'low_24h' => $market->price,
                    'volume_24h' => 0,
                    'volume_pair_24h' => 0
                ];
            }
            $this->currencyRepository->update($currency, ['usd_rate' => $price]);
            $this->marketRepository->update($market, $dataUpdate);

            $dataInfo = [
                'market_id' => $market->id,
                'market_code' => $market->symbol,
                'price_change_24h' => $dataUpdate['price_change_24h'],
                'price' => $dataPrice,
                'hight_24h' => $dataUpdate['hight_24h'],
                'low_24h' => $dataUpdate['low_24h'],
                'volume_24h' => $dataUpdate['volume_24h'],
                'volume_pair_24h' => $dataUpdate['volume_pair_24h'],
                'quote' => [
                    'priceUSD' => $currencyPair->usd_rate
                ]
            ];
            broadcast(new HookTradeMarket($market->symbol, $dataHis))->via('pusher');
            broadcast(new HookMarketInfo($dataInfo))->via('pusher');
        } catch (\Exception $e) {
            \Log::channel('trade_hook')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function testPusher()
    {   
        try {
            $dataInfo = 1;
            broadcast(new PeertopeerChat($dataInfo))->via('pusher');
            dd(broadcast(new HookMarketInfo($dataInfo))->via('pusher'));
            $dataHis = [
                // 'trade_id' => 24,
                // 'amount' => $data['amount'],
                // 'amount_pair' =>  $amountPair,
                // 'price' => $data['price'],
                // 'fee' => $fee,
                // 'fill' => $data['amount'],
                // 'trade_type' => $trade->trade_type,
                // 'is_maker' => $data['isMaker'],
                'created_at' => Carbon::now()->toDateTimeString(),
            ];
            // broadcast(new HookTradeMarket('BNB_BUSD', $dataHis))->via('pusher');
            // return 1;
            broadcast(new HookMarketInfo($dataHis))->via('pusher');
            dd(1);
        } catch (\Exception $e) {
            //throw $th;
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
