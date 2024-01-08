<?php

namespace Modules\Staking\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Staking\Repositories\OrderRepository;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;

class CalRewardStake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'cal:reward-stake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cal reward stake.';

    protected $orderRepository;
    protected $walletRepository;
    protected $transactionRepository;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderRepository $orderRepository, WalletRepository $walletRepository, TransactionRepository $transactionRepository)
    {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            \Log::info("CalRewardStake running");
            $orders = $this->orderRepository->getByAttributes(['status' => 0]);
            $now = now()->startOfHour();
            foreach ($orders as $order) {
                $term = $order->term;
                if ($term) {
                    $package = $term->package;
                    if ($package) {
                        $amount_reward = $order->amount_reward;
                        $hour_reward = $package->hour_reward;
                        $apr = $term->apr_reward;
                        $last_time_reward = $order->last_time_reward;
                        $redemption_date = $order->redemption_date;
                        $redemption_date = Carbon::parse($redemption_date);
                        $result = $now->gt($redemption_date);
                        if ($result) {
                            $this->handleRedeemStaking($order, $package);
                        } else {
                            $rate = $this->calApr($apr, $hour_reward);
                            $diffHour = $now->diffInHours($last_time_reward);
                            if ($diffHour > 0 && $diffHour >= $hour_reward) {
                                $wallet = $this->walletRepository->where("customer_id", $order->customer_id)->where("currency_id",  $package->currency_reward_id)->first();
                                if (!$wallet) {
                                    $dataCreate = [
                                        'customer_id' => $order->customer_id,
                                        'currency_id' => $package->currency_reward_id,
                                        'type' => 'CRYPTO',
                                        'balance' => 0,
                                        'status' => true,
                                    ];
                                    $wallet = $this->walletRepository->create($dataCreate);
                                }
                                $rewardCurrency = $package->currencyReward;
                                $reward = ($amount_reward * $rate) / 100;
                                $newBalance = $wallet->balance + $reward;
                                $dataCreate = [
                                    'customer_id' => $order->customer_id,
                                    'currency_id' => $package->currency_reward_id,
                                    'blockchain_id' => null,
                                    'action' => TypeTransactionActionEnum::REWARD_STAKING,
                                    'amount' => $reward,
                                    'amount_usd' => $reward * $rewardCurrency->usd_rate,
                                    'fee' => 0,
                                    'balance' => $newBalance,
                                    'balanceBefore' => $wallet->balance,
                                    'payment_method' => 'CRYPTO',
                                    'txhash' => random_strings(30),
                                    'from' => "",
                                    'to' => "",
                                    'tag' => null,
                                    'order' => $order->id,
                                    'note' => null,
                                    'status' => StatusTransactionEnum::COMPLETED
                                ];

                                event(new CreateTransaction($dataCreate));
                                event(new UpdateBalanceWallet($newBalance, $wallet->id));
                                $last_time_reward = Carbon::parse($last_time_reward)->addHours($hour_reward);
                                $this->orderRepository->update($order, ['total_amount_reward' => $order->total_amount_reward + $reward, 'last_time_reward' => $last_time_reward]);
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    private function handleRedeemStaking($order, $package)
    {
        try {
            $wallet = $this->walletRepository->where("customer_id", $order->customer_id)->where("currency_id",  $package->currency_stake_id)->first();
            if (!$wallet) {
                $dataCreate = [
                    'customer_id' => $order->customer_id,
                    'currency_id' => $package->currency_stake_id,
                    'type' => 'CRYPTO',
                    'balance' => 0,
                    'status' => true,
                ];
                $wallet = $this->walletRepository->create($dataCreate);
            }
            $checkTransaction = $this->transactionRepository->findByAttributes([
                'customer_id' => $order->customer_id,
                'order' => $order->id,
                'action' => TypeTransactionActionEnum::REDEEM_STAKING,
            ]);
            if (!$checkTransaction) {
                $this->orderRepository->update($order, ['status' => 1]);
                $stakeCurrency = $package->currencyStake;
                $amount_stake = $order->amount_stake;
                $newBalance = $wallet->balance + $amount_stake;
                $dataCreate = [
                    'customer_id' => $order->customer_id,
                    'currency_id' => $package->currency_reward_id,
                    'blockchain_id' => null,
                    'action' => TypeTransactionActionEnum::REDEEM_STAKING,
                    'amount' => $amount_stake,
                    'amount_usd' => $amount_stake * $stakeCurrency->usd_rate,
                    'fee' => 0,
                    'balance' => $newBalance,
                    'balanceBefore' => $wallet->balance,
                    'payment_method' => 'CRYPTO',
                    'txhash' => random_strings(30),
                    'from' => "",
                    'to' => "",
                    'tag' => null,
                    'order' => $order->id,
                    'note' => null,
                    'status' => StatusTransactionEnum::COMPLETED
                ];

                event(new CreateTransaction($dataCreate));
                event(new UpdateBalanceWallet($newBalance, $wallet->id));
            } else {
                \Log::error(`{$order->id} unstaked but call action unstake`);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    private function calApr($apr, $hour_reward)
    {
        $aprDay = $apr / 365;
        $aprHour = $aprDay / 24;
        return $aprHour * $hour_reward;
    }
}
