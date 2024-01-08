<?php

namespace Modules\Staking\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Staking\Repositories\PackageRepository;
use Modules\Staking\Repositories\PackageTermRepository;
use Modules\Staking\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Staking\Jobs\CalCommissionStake;
use Modules\Staking\Transformers\Orders\Frontend\FullOrderTransformer;
use Modules\Staking\Transformers\Packages\FullPackageTransformer;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;

class PublicApiController extends BaseApiController
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

    public function getPackagesList()
    {
        try {
            $packages = $this->packageRepository->getByAttributes(['status' => true]);
            if ($packages) {
                return $this->respondWithData(FullPackageTransformer::collection($packages));
            } else {
                return $this->respondWithError(trans('staking::packages.messages.package_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getPackageInfo($packageId)
    {
        try {
            $package = $this->packageRepository->findByAttributes(['id' => $packageId, 'status' => true]);
            if ($package) {
                return $this->respondWithData(['package' => new FullPackageTransformer($package)]);
            } else {
                return $this->respondWithError(trans('staking::packages.messages.package_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function submitStake(Request $request)
    {
        try {
            $packageId = $request->get('packageId');
            $term_id = $request->get('term_id');
            $amount = $request->get('amount');
            if ($amount <= 0) {
                return $this->respondWithError(trans('staking::orders.messages.amount_large_than_0'));
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
                        return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                    }

                    if ($wallet->balance < $amount) {
                        return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                    }
                    $newBalance = $wallet->balance - $amount;
                    event(new UpdateBalanceWallet($newBalance, $wallet->id));
                    $amount_usd_stake = $amount * $stakeCurrency->usd_rate;
                    $amount_reward = $amount_usd_stake / $rewardCurrency->usd_rate;
                    $now = now();
                    $redemption_date = null;
                    if ($term->type == 'LOCKED') {
                        $redemption_date =  now()->addDays($term->day_reward);
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
                    return $this->respondWithSuccess(['message' => trans('staking::orders.messages.staking_success'), 'url_return' => route('fe.staking.staking.mystaking')]);
                } else {
                    return $this->respondWithError(trans('staking::packageterms.messages.packageterm_not_found'));
                }
            } else {
                return $this->respondWithError(trans('staking::packages.messages.package_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getListMyStake(Request $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $orders = $this->orderRepository->getListMyStake($customer->id, $request);
            return $this->respondWithData(['orders' => FullOrderTransformer::collection($orders)]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function redeemStake(Request $request)
    {
        try {
            $orderId = $request->get('orderId');
            if (!$orderId) {
                return $this->respondWithError(trans('staking::orders.messages.order_not_found'));
            }

            $customer = auth()->guard('customer')->user();
            $order = $this->orderRepository->findByAttributes(['customer_id' => $customer->id, 'id' => $orderId, 'status' => 0]);
            if ($order) {
                $term = $order->term;
                $package = $term->package;
                return $this->handleRedeemStaking($order, $package);
            } else {
                return $this->respondWithError(trans('staking::orders.messages.order_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
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
                return $this->respondWithSuccess(['message'=>trans('staking::orders.messages.unstake_success')]);
            } else {
                \Log::error(`{$order->id} unstaked but call action unstake`);

                return $this->respondWithError('Unstake failed, please contact admin');
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
