<?php

namespace Modules\Loyalty\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Loyalty\Repositories\OrderRepository;
use Modules\Loyalty\Repositories\CommissionRepository;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Customer\Repositories\CustomerRepository;;
use Modules\Customer\Helpers\CustomerHelper;
use Modules\Wallet\Events\IncreaseBalanceWallet;
use Modules\Affiliate\Repositories\AffiliateRepository;
use Modules\Affiliate\Enums\TypeAffiliate;

class CalRewardLoyalty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'cal:reward-loyalty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cal reward loyalty.';

    protected $orderRepository;
    protected $walletRepository;
    protected $transactionRepository;
    protected $customerRepository;
    protected $commissionRepository;
    protected $affiliateRepository;
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
         WalletRepository $walletRepository, 
         TransactionRepository $transactionRepository,
         CustomerRepository $customerRepository,
         CommissionRepository $commissionRepository,
         AffiliateRepository $affiliateRepository
    ) {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
        $this->customerRepository = $customerRepository;
        $this->commissionRepository = $commissionRepository;
        $this->affiliateRepository = $affiliateRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            \Log::info("CalRewardLoyalty running");
            $orders = $this->orderRepository->getByAttributes(['status' => 0]);
            $now = now()->startOfHour();
            foreach ($orders as $order) {
                $term = $order->term;
                if ($term) {
                    $package = $term->package;
                    if ($package) {
                        $amount_stake = $order->amount_stake;
                        $hour_reward = $package->hour_reward;
                        $apr = $term->apr_reward;
                        $last_time_reward = $order->last_time_reward;
                        $redemption_date = $order->redemption_date;
                        $redemption_date = Carbon::parse($redemption_date);

                        $rate = $this->calApr($apr, $hour_reward);
                        $diffHour = $now->diffInHours($last_time_reward);
                        if ($diffHour > 0 && $diffHour >= $hour_reward) {
                            $wallet = $this->walletRepository->where("customer_id", $order->customer_id)->where("currency_id",  $package->currency_cashback_id)->first();
                            if (!$wallet) {
                                $dataCreate = [
                                    'customer_id' => $order->customer_id,
                                    'currency_id' => $package->currency_cashback_id,
                                    'type' => 'CRYPTO',
                                    'balance' => 0,
                                    'status' => true,
                                ];
                                $wallet = $this->walletRepository->create($dataCreate);
                            }
                            $rewardCurrency = $package->currencyReward;
                            $reward = ($amount_stake * $rate) / 100;
                            $newBalance = $wallet->balance + $reward;
                            $dataCreate = [
                                'customer_id' => $order->customer_id,
                                'currency_id' => $package->currency_cashback_id,
                                'blockchain_id' => null,
                                'action' => TypeTransactionActionEnum::REWARD_LOYALTY,
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
                            //Tra hoa hong lai tren lai
                            $this->handleCalCommissionLoyalty($order);
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
                    'currency_id' => $package->currency_cashback_id,
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

    private function handleCalCommissionLoyalty($order) {
        $term = $order->term;
        $package = $term->package;
        $commissions =  $this->affiliateRepository->findByAttributes([
            'type' => TypeAffiliate::INTEREST_BONUS,
            'status' => true
        ]);
        $customer = $this->customerRepository->find($order->customer_id);
        $customerFloors = CustomerHelper::getParentCustomer($customer);
        $currencyStake = $package->currencyStake;
        $termMatching = $package->term_matching;
        foreach ($commissions as $commission) {
            $key = array_search($commission->level, array_column($customerFloors, 'level'));
            if ($key !== false && isset($customerFloors[$key]) && $commission->commission != 0) {
                $cus = $customerFloors[$key];
                if($cus['term_matching'] >= $termMatching) {
                    $this->hanldeCalcommission($cus, $order, $commission, $currencyStake, $term, $package);
                }
            }
        }
    }

    private function hanldeCalcommission($customer, $order, $commission, $currencyStake, $term, $package)
    {
        $apr = $term->apr_reward;
        $hour_reward = $package->hour_reward;
        $rate = $this->calApr($apr, $hour_reward);
        $amount = $commission->commission;
        if ($commission->type == 1) {
            $amount = ($order->amount_stake * $rate) / 100 * $commission->commission / 100;
        }

        // $checkTransaction = $this->transactionRepository->findByAttributes([
        //     'customer_id' => $customer['id'],
        //     'currency_id' => $currencyStake->id,
        //     'order' => $order->id,
        //     'action' => TypeTransactionActionEnum::COMMISSION_LOYALTY,
        // ]);
        // if (!$checkTransaction) {
        //     event(new IncreaseBalanceWallet($amount, $customer['id'], $currencyStake->id, TypeTransactionActionEnum::COMMISSION_LOYALTY, $order->id));
        // }
        event(new IncreaseBalanceWallet($amount, $customer['id'], $currencyStake->id, TypeTransactionActionEnum::COMMISSION_LOYALTY, $order->id));
    }
}
