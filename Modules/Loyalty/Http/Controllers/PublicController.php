<?php

namespace Modules\Loyalty\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Loyalty\Repositories\PackageTermRepository;
use Modules\Loyalty\Repositories\OrderRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Modules\Loyalty\Jobs\CalCommissionLoyalty;
use Modules\Loyalty\Transformers\Orders\Frontend\FullOrderTransformer;
use Modules\Loyalty\Transformers\Packages\FullPackageTransformer;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;

class PublicController extends BasePublicController
{
    /**
     * @var Application
     */
    private $app;
    private $packageRepository;
    private $walletRepository;
    private $orderRepository;
    private $packageTermRepository;
    private $transactionRepository;
    private $customerRepository;

    public function __construct(
        Application $app,
        PackageRepository $packageRepository,
        PackageTermRepository $packageTermRepository,
        OrderRepository $orderRepository,
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository,
        CustomerRepository $customerRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->packageRepository = $packageRepository;
        $this->packageTermRepository = $packageTermRepository;
        $this->orderRepository = $orderRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
        $this->customerRepository = $customerRepository;
    }

    public function getStakingList()
    {
        try {
            $customer = auth()->guard('customer')->user();
            $packages = $this->packageRepository->getByAttributes(['status' => true]);
            $orders;
            if($customer) {
                $orders = $this->orderRepository->getByAttributes([
                    'status' => false,
                    'customer_id' => $customer->id
                ]);
            }
            return view('loyalties.list-packages', compact('packages', 'orders'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    public function getMyStaking()
    {
        try {
            $customerID = auth()->guard('customer')->user()->id;
            $packages = [];
            $orders = $this->orderRepository->getByAttributes([
                'customer_id' => $customerID,
                'status' => false
            ]);
            foreach ($orders as $order) {
                $termPackage = $order->term;
                $package = $termPackage->package;
                array_push($packages, $package);
            }
            return view('loyalties.my-package', compact('packages'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getMyHistory()
    {
        try {
            $customerID = auth()->guard('customer')->user()->id;
            $packages = [];
            $orders = $this->orderRepository->getByAttributes([
                'customer_id' => $customerID,
                'status' => false
            ]);
            foreach ($orders as $order) {
                $termPackage = $order->term;
                $package = $termPackage->package;
                array_push($packages, $package);
            }
            return view('loyalties.history', compact('packages'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getStakingDetail($packageId, Request $request)
    {
        try {
            $customerID = auth()->guard('customer')->user()->id;
            $package = $this->packageRepository->find($packageId);
            $transactions = [];
            $order;
            if ($package) {
                $stakeCurrencyId = $package->currencyStake->id;
                $term = $request->get('term');
                $wallet = $this->walletRepository->where("customer_id", $customerID)->where("currency_id", $stakeCurrencyId)->first();
                $order = $this->orderRepository->findByAttributes([
                    'customer_id' => $customerID,
                    'packageterm_id' => $term
                ]);
                if($order) {
                    $actions = ['SUBCRIBE_LOYALTY', 'COMMISSION_LOYALTY', 'REWARD_LOYALTY'];
                    $transactions = $this->transactionRepository->where('order', $order->id)
                    ->where('customer_id', $customerID)
                    ->whereIn('action', $actions)
                    ->get();
                    info($transactions);
                }
                return view('loyalties.detail-package', compact('package', 'term', 'wallet', 'order', 'transactions'));
            } else {
                return back()->withErrors(trans('staking::packages.messages.not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function subcribeLoyalty(Request $request)
    {
        try {
            $packageId = $request->get('packageId');
            $term_id = $request->get('term_id');
            $amount = $request->get('amount');
            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findByAttributes([
                'customer_id' => $customer->id,
                'packageterm_id' => $term_id,
                'status' => false
            ]);
            if($order) {
                return back()->withErrors(trans('loyalty::orders.messages.subcribe_loyalty_failed'));
            }
            if ($amount <= 0) {
                return back()->withErrors(trans('loyalty::orders.messages.amount_large_than_0'));
            }
            $package = $this->packageRepository->findByAttributes(['id' => $packageId, 'status' => true]);
            if ($package) {
                if($customer->term_matching < $package->term_matching) {
                    $dataUpdate = [
                        'term_matching' => $package->term_matching
                    ];
                    $this->customerRepository->update($customer, $dataUpdate);
                }
                $term = $this->packageTermRepository->findByAttributes(['id' => $term_id, 'package_id' => $package->id]);
                if ($term) {
                    $stakeCurrency = $package->currencyStake;
                    $rewardCurrency = $package->currencyReward;
                    $walletStake = $this->walletRepository->where("customer_id", $customer->id)->where("currency_id", $stakeCurrency->id)->first();
                    if (!$walletStake) {
                        return back()->withErrors(trans('wallet::wallets.messages.balance_dont_enough'));
                    }

                    if ($walletStake->balance < $amount) {
                        return back()->withErrors(trans('wallet::wallets.messages.balance_dont_enough'));
                    }
                    $newBalanceStake = $walletStake->balance - $amount;
                    event(new UpdateBalanceWallet($newBalanceStake, $walletStake->id));
                    $amount_usd_stake = $amount * $stakeCurrency->usd_rate;
                    // $amount_reward = $amount_usd_stake / $rewardCurrency->usd_rate;
                    if( $rewardCurrency->usd_rate != 0){
                        $amount_reward = $amount_usd_stake / $rewardCurrency->usd_rate;
                    }else{
                        $amount_reward = $amount_usd_stake;
                    }
                    $now = now();
                    $redemption_date = null;
                    if ($term->type == 'LOCKED') {
                        $redemption_date =  now()->addDays($term->day_reward);
                    } elseif ($term->type == 'LOCKED-PRINCIPLE-PREPAID') {
                        $walletReward = $this->walletRepository->where("customer_id", $customer->id)->where("currency_id", $rewardCurrency->id)->first();
                        if(!$walletReward) {
                            $dataCreate = [
                                'customer_id' => $customer->id,
                                'currency_id' => $rewardCurrency->id,
                                'type' => 'CRYPTO',
                                'balance' => 0,
                                'status' => true,
                            ];
                            $walletReward = $this->walletRepository->create($dataCreate);
                        }
                        $rewardAmount = $package->min_stake * $package->principal_convert_rate / 100;
                        $newBalanceReward = $walletReward->balance + $rewardAmount;
                        event(new UpdateBalanceWallet($newBalanceReward, $walletReward->id));
                    }
                    $dataCreate = [
                        'code' => random_strings(20),
                        'customer_id' => $customer->id,
                        'packageterm_id' => $term->id,
                        'amount_stake' => $amount,
                        'amount_usd_stake' => $amount_usd_stake,
                        // 'amount_reward' => $amount_reward,
                        'amount_reward' => $rewardAmount,
                        'subscription_date' =>  $now,
                        'redemption_date' => $redemption_date,
                        'last_time_reward' => now()->startOfHour(),
                        'total_amount_reward' => 0,
                    ];
                    $order = $this->orderRepository->create($dataCreate);

                    $dataCreate = [
                        'customer_id' => $customer->id,
                        'currency_id' => $stakeCurrency->id,
                        'blockchain_id' => null,
                        'action' => TypeTransactionActionEnum::SUBCRIBE_LOYALTY,
                        'amount' => $amount,
                        'amount_usd' => $amount * $stakeCurrency->usd_rate,
                        'fee' => 0,
                        'balance' => $newBalanceStake,
                        'balanceBefore' => $walletStake->balance,
                        'payment_method' => 'CRYPTO',
                        'txhash' => random_strings(30),
                        'from' => "",
                        'to' => "",
                        'tag' => null,
                        'order' => $order->id,
                        'note' => null,
                        'status' => StatusTransactionEnum::COMPLETED
                    ];
                    $this->packageTermRepository->update($term, ['total_stake' => $term->total_stake + $amount]);
                    $this->transactionRepository->create($dataCreate);

                    $dataCreate = [
                        'customer_id' => $customer->id,
                        'currency_id' => $rewardCurrency->id,
                        'blockchain_id' => null,
                        'action' => TypeTransactionActionEnum::REWARD_LOYALTY,
                        'amount' => $rewardAmount,
                        'amount_usd' => $rewardAmount * $rewardCurrency->usd_rate,
                        'fee' => 0,
                        'balance' => $newBalanceReward,
                        'balanceBefore' => $walletReward->balance,
                        'payment_method' => 'CRYPTO',
                        'txhash' => random_strings(30),
                        'from' => "",
                        'to' => "",
                        'tag' => null,
                        'order' => $order->id,
                        'note' => null,
                        'status' => StatusTransactionEnum::COMPLETED
                    ];
                    $this->transactionRepository->create($dataCreate);
                    CalCommissionLoyalty::dispatch($order->id); //Tra hoa hong cho sponsor lv 1 khi dang ky package
                    return redirect()->route('fe.loyalty.loyalty.mystaking')->with('success', 'Staking successful');
                } else {
                    return back()->withErrors(trans('loyalty::packageterms.messages.packageterm_not_found'));
                }
            } else {
                return back()->withErrors(trans('loyalty::packages.messages.package_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
