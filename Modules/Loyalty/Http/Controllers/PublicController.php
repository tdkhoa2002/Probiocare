<?php

namespace Modules\Loyalty\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Loyalty\Repositories\PackageTermRepository;
use Modules\Loyalty\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Modules\Loyalty\Jobs\CalCommissionStake;
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

    public function __construct(
        Application $app,
        PackageRepository $packageRepository,
        PackageTermRepository $packageTermRepository,
        OrderRepository $orderRepository,
        WalletRepository $walletRepository,
        TransactionRepository $transactionRepository
    ) {
        parent::__construct();
        $this->app = $app;
        $this->packageRepository = $packageRepository;
        $this->packageTermRepository = $packageTermRepository;
        $this->orderRepository = $orderRepository;
        $this->walletRepository = $walletRepository;
        $this->transactionRepository = $transactionRepository;
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
            $totalSystemStake = $this->orderRepository->where("amount_usd_stake", "<>", "null")->sum('amount_usd_stake');
            $totalMyStake = $this->orderRepository
            ->where("customer_id", $customerID)
            ->where("amount_usd_stake", "<>", "null")->sum('amount_usd_stake');
            return view('stakings.my-staking', compact('totalSystemStake','totalMyStake'));
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
            if ($package) {
                $stakeCurrencyId = $package->currencyStake->id;
                $term = $request->get('term');
                $wallet = $this->walletRepository->where("customer_id", $customerID)->where("currency_id", $stakeCurrencyId)->first();
                return view('loyalties.detail-package', compact('package', 'term', 'wallet'));
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
            if ($amount <= 0) {
                // return $this->respondWithError(trans('staking::orders.messages.amount_large_than_0'));
                return back()->withErrors(trans('staking::orders.messages.amount_large_than_0'));
            }
            $package = $this->packageRepository->findByAttributes(['id' => $packageId, 'status' => true]);
            if ($package) {
                $term = $this->packageTermRepository->findByAttributes(['id' => $term_id, 'package_id' => $package->id]);
                if ($term) {
                    $stakeCurrency = $package->currencyStake;
                    $rewardCurrency = $package->currencyReward;
                    
                    $customer = auth()->guard('customer')->user();
                    $wallet = $this->walletRepository->where("customer_id", $customer->id)->where("currency_id", $stakeCurrency->id)->first();
                    if (!$wallet) {
                        // return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                        return back()->withErrors(trans('wallet::wallets.messages.balance_dont_enough'));
                    }

                    if ($wallet->balance < $amount) {
                        // return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                        return back()->withErrors(trans('wallet::wallets.messages.balance_dont_enough'));
                    }
                    $newBalance = $wallet->balance - $amount;
                    event(new UpdateBalanceWallet($newBalance, $wallet->id));
                    $amount_usd_stake = $amount * $stakeCurrency->usd_rate;
                    $amount_reward = $amount_usd_stake / $rewardCurrency->usd_rate;
                    $now = now();
                    $redemption_date = null;
                    if ($term->type == 'LOCKED') {
                        $redemption_date =  now()->addDays($term->day_reward);
                    } elseif ($term->type == 'LOCKED-PRINCIPLE-PREPAID') {
                        $wallet = $this->walletRepository->where("customer_id", $customer->id)->where("currency_id", $rewardCurrency->id)->first();
                        $commissions =  $package->commissions;
                        foreach ($commissions as $commission) {
                            if ($commission->level == 0 && $commission->status == true) {
                                $rewardAmount = $package->min_stake * $commission->commission / 100;
                                $newBalance = $wallet->balance + $rewardAmount;
                            }
                        }
                        event(new UpdateBalanceWallet($newBalance, $wallet->id));
                    }
                    $dataCreate = [
                        'code' => random_strings(20),
                        'customer_id' => $customer->id,
                        'packageterm_id' => $term->id,
                        'amount_stake' => $amount,
                        'amount_usd_stake' => $amount_usd_stake,
                        'amount_reward' => $amount_reward,
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
                        'action' => TypeTransactionActionEnum::STAKING,
                        'amount' => $amount,
                        'amount_usd' => $amount * $stakeCurrency->usd_rate,
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
                    $this->packageTermRepository->update($term, ['total_stake' => $term->total_stake + $amount]);
                    $this->transactionRepository->create($dataCreate);
                    CalCommissionStake::dispatch($order->id);
                    // return $this->respondWithSuccess(['message' => trans('staking::orders.messages.staking_success'), 'url_return' => route('fe.staking.staking.mystaking')]);
                    // return view('loyalties.detail-package', compact('package', 'term', 'wallet'));
                    return redirect()->route('fe.loyalty.loyalty.mystaking')->with('success', 'Staking successful');
                } else {
                    // return $this->respondWithError(trans('staking::packageterms.messages.packageterm_not_found'));
                    return back()->withErrors(trans('staking::packageterms.messages.packageterm_not_found'));
                }
            } else {
                // return $this->respondWithError(trans('staking::packages.messages.package_not_found'));
                return back()->withErrors(trans('staking::packages.messages.package_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
