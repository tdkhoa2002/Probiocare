<?php

namespace Modules\Staking\Http\Controllers\Api;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Staking\Repositories\PackageRepository;
use Modules\Staking\Repositories\PackageTermRepository;
use Modules\Staking\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Staking\Transformers\Packages\FullPackageTransformer;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Repositories\TransactionRepository;

class PackagesController extends BaseApiController
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
            $packages = $this->packageRepository->getPackagesList();
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
}
