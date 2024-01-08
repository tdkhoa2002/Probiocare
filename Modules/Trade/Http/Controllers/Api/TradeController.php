<?php

namespace Modules\Trade\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Trade\Transformers\Trades\TradeTransformer;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Trade\Libraries\Tatum;
use Modules\Wallet\Repositories\WalletRepository;

class TradeController extends Controller
{
    /**
     * @var TradeRepository
     */
    private $tradeRepository;
    private $walletRepository;

    public function __construct(TradeRepository $tradeRepository, WalletRepository $walletRepository)
    {
        $this->tradeRepository = $tradeRepository;
        $this->walletRepository = $walletRepository;
    }

    public function indexServerSide(Request $request)
    {
        return TradeTransformer::collection($this->tradeRepository->serverPaginationFilteringFor($request));
    }

    public function cancelTrade($tradeId)
    {
        try {
            $trade = $this->tradeRepository->findByAttributes(['id' => $tradeId, 'status' => 0]);
            if ($trade) {
                $market = $trade->market;
                $customer_id = $trade->customer_id;
                $walletBase = $this->walletRepository->findByAttributes(['customer_id' => $customer_id, 'currency_id' => $market->currency_id]);
                $walletQuote = $this->walletRepository->findByAttributes(['customer_id' => $customer_id, 'currency_id' => $market->currency_pair_id]);
                if (!$walletBase || !$walletQuote) {
                    return response()->json([
                        'errors' => true,
                        'message' => trans('trade::trades.messages.not_found'),
                    ]);
                }

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
                    'customer_id' => $customer_id,
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
                    'note' => "Admin Cancel Trade",
                    'status' => StatusTransactionEnum::COMPLETED
                ];
                event(new CreateTransaction($dataCreate));
                return response()->json([
                    'errors' => false,
                    'message' =>  trans('trade::trades.messages.cancel_trade_success'),
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'message' => trans('trade::trades.messages.not_found'),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errors' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
