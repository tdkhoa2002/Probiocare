<?php

namespace Modules\Staking\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Staking\Repositories\PackageRepository;
use Modules\Staking\Repositories\PackageTermRepository;
use Modules\Staking\Repositories\OrderRepository;
use Illuminate\Http\Request;

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

    public function __construct(
        Application $app,
        PackageRepository $packageRepository,
        PackageTermRepository $packageTermRepository,
        OrderRepository $orderRepository,
        WalletRepository $walletRepository,
    ) {
        parent::__construct();
        $this->app = $app;
        $this->packageRepository = $packageRepository;
        $this->packageTermRepository = $packageTermRepository;
        $this->orderRepository = $orderRepository;
        $this->walletRepository = $walletRepository;
    }

    public function getStakingList()
    {
        try {
            $packages = $this->packageRepository->getByAttributes(['status' => true]);
            return view('stakings.staking-list', compact('packages'));
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
                return view('stakings.staking', compact('package', 'term', 'wallet'));
            } else {
                return back()->withErrors(trans('staking::packages.messages.not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
