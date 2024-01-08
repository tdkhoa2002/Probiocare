<?php

namespace Modules\MarketMaker\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Trade\Repositories\TradeHistoryRepository;
use Modules\Trade\Repositories\MarketRepository;
use Modules\Trade\Repositories\TradeRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\MarketMaker\Repositories\VolumnizerRepository;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Carbon\Carbon;
use Modules\Trade\Events\HookTradeMarket;
use Modules\Trade\Events\HookMarketInfo;
use Modules\Customer\Entities\Customer;

class Volumnizer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:volumnizer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is the make volumnizer.';

    private $tradeHistoryRepository;
    private $marketRepository;
    private $tradeRepository;
    private $walletRepository;
    private $customerRepository;
    private $volumnizerRepository;
    private $currencyRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        TradeHistoryRepository $tradeHistoryRepository,
        MarketRepository $marketRepository,
        TradeRepository $tradeRepository,
        WalletRepository $walletRepository,
        CustomerRepository $customerRepository,
        VolumnizerRepository $volumnizerRepository,
        CurrencyRepository $currencyRepository
    ) {
        parent::__construct();
        $this->tradeHistoryRepository = $tradeHistoryRepository;
        $this->marketRepository = $marketRepository;
        $this->tradeRepository = $tradeRepository;
        $this->walletRepository = $walletRepository;
        $this->customerRepository = $customerRepository;
        $this->volumnizerRepository = $volumnizerRepository;
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $volumnizers = $this->volumnizerRepository->getByAttributes([
                'status' => 1
            ]);
            $now = Carbon::now()->toDateTimeString();
            foreach ($volumnizers as $volumnizer) {
                if (
                    $now >= $volumnizer->start_time &&
                    $now <= $volumnizer->end_time &&
                    $volumnizer->checkpoint <= $volumnizer->end_time
                ) {
                    if ($now >= $volumnizer->checkpoint) {
                        $pair = $volumnizer->market;
                        $customer = $volumnizer->customer;
                        if ($pair) {
                            $currency = $pair->currency;
                            $currencyPair = $pair->currencyPair;
                            $amount = $volumnizer->amount;
                            $price = $pair->price;
                            $amountBase = $amount;
                            $amountQuote = $amount * $price;
                            $this->executeOrder('SELL', $pair, $customer, $amountBase, $amountQuote, $price, $currency);
                            $this->executeOrder('BUY', $pair, $customer, $amountBase, $amountQuote, $price, $currencyPair);
                        }
                        $updatedCheckpoint = Carbon::parse($volumnizer->checkpoint);
                        $updatedCheckpoint->addMinutes($volumnizer->interval);
                        $this->volumnizerRepository->update($volumnizer, [
                            'checkpoint' => $updatedCheckpoint
                        ]);
                    }
                } else {
                    $this->volumnizerRepository->update($volumnizer, [
                        'status' => 0
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    private function executeOrder($type, $pair, $customer, $amount, $amountPair, $price, $currency)
    {
        $dataTrade = [
            'customer_id' => $customer->id,
            'market_id' => $pair->id,
            'amount' => $amount,
            'amount_pair' => $amountPair,
            'price_was' => $price,
            'total_fee' => 0,
            'fee' => 0,
            'fill' => 0,
            'trade_type' => $type,
            'order_id' => null,
            'status' => 1,
        ];

        $pairService = $pair->service_base_code . '/' . $pair->service_quote_code;
        $trade = $this->tradeRepository->create($dataTrade);

        $this->executeOrderHistory($trade);

        $dataCreate = [
            'customer_id' => $customer->id,
            'currency_id' => $currency->id,
            'blockchain_id' => null,
            'action' => TypeTransactionActionEnum::TRADE_OUT,
            'amount' => $amount,
            'amount_usd' => $amount * $currency->usd_rate,
            'fee' => 0,
            'balance' => 0,
            'balanceBefore' => 0,
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
    }

    private function executeOrderHistory($trade)
    {
        $market = $this->marketRepository->find($trade->market_id);
        $amount = $trade->amount;
        $amountPair =  $trade->amount_pair;
        $currency = $market->currency;
        $fee_percent = $market->maker;

        if ($trade->trade_type == 'SELL') {
            $amount = $amount * $trade->price_was;
            $currency = $market->currencyPair;
        }
        $fee = ($amount * $fee_percent) / 100;
        $this->tradeRepository->update($trade, ['fill' => $trade->amount, 'fee' => $fee, 'total_fee' => $trade->total_fee + $fee]);
        $dataCreate = [
            'customer_id' => $trade->customer_id,
            'currency_id' => $currency->id,
            'blockchain_id' => null,
            'action' => TypeTransactionActionEnum::TRADE_IN,
            'amount' => $amount,
            'amount_usd' => $amount * $currency->usd_rate,
            'fee' => $fee,
            'balance' => 0,
            'balanceBefore' => 0,
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
            'amount' => $trade->amount,
            'amount_pair' =>  $amountPair,
            'price' => $trade->price_was,
            'fee' => $fee,
            'fill' => $trade->amount,
            'trade_type' => $trade->trade_type,
            'is_maker' => 1,
            'created_at' => Carbon::now('UTC')->toDateTimeString(),
        ];
        $this->tradeHistoryRepository->create($dataHis);
        $this->calDataPair($market, $dataHis);
    }

    private function calDataPair($market, $dataHis)
    {
        try {
            // $dataHis['created_at'] = Carbon::now('UTC')->toDateTimeString();
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
            return $e->getMessage();
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
