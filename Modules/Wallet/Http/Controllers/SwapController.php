<?php

namespace Modules\Wallet\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Modules\Wallet\Enums\TypeTransactionActionEnum;

class SwapController extends BasePublicController
{
    private $walletRepository;
    private $currencyRepository;
    private $blockchainRepository;
    private $transactionRepository;

    public function __construct(
        WalletRepository $walletRepository,
        CurrencyRepository $currencyRepository,
        BlockchainRepository $blockchainRepository,
        TransactionRepository $transactionRepository,
    ) {
        parent::__construct();
        $this->walletRepository = $walletRepository;
        $this->currencyRepository = $currencyRepository;
        $this->blockchainRepository = $blockchainRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function convert()
    {
        try {
            return view('swaps.index');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
