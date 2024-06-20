<?php

namespace Modules\ShoppingCart\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Loyalty\Repositories\PackageRepository;
use Modules\Loyalty\Repositories\PackageTermRepository;
use Modules\Loyalty\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Loyalty\Jobs\CalCommissionLoyalty;
use Modules\Loyalty\Transformers\Orders\Frontend\FullOrderTransformer;
use Modules\Loyalty\Transformers\Packages\FullPackageTransformer;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\ShoppingCart\Facades\Cart;

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

    public function getCartInfo() {
        try {
            $customer = auth()->guard('customer')->user();
            $count = Cart::count();
            if ($count == 0) {
                return $this->respondWithError(trans('staking::packages.messages.package_not_found'));
            } else {
                $subtotal = Cart::subtotalPrice();
                $wallet = $this->walletRepository->findByAttributes([
                    'customer_id' => $customer->id,
                    'currency_id' => 2
                ]);
                if(!$wallet) {
                    $plc = 0;
                } else {
                    $plc = $wallet->balance;
                }
                $total = $subtotal - $plc;
                $carts = Cart::content();
                return $this->respondWithData([
                    'subtotal' => number_format($subtotal),
                    'total' => number_format($total),
                    'carts' => $carts,
                    'plc' => $plc
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
