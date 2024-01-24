<?php

namespace Modules\Customer\Http\Controllers\Api;

use Modules\Wallet\Transformers\Wallets\WalletTransformer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Customer\Entities\Customer;

class WalletController extends BaseApiController
{
    private $walletRepository;
    public function __construct(WalletRepository $walletRepository) {
        $this->walletRepository = $walletRepository;
    }

    public function getListWallets(Customer $customer, Request $request)
    {
        return WalletTransformer::collection($this->walletRepository->getListWalletsCustomerAdmin($customer->id, $request));
    }
}
