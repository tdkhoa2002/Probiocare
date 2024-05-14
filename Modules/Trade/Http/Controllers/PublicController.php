<?php

namespace Modules\Trade\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Customer\Repositories\CountryRepository;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\Customer\Repositories\CustomerCodeRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Trade\Repositories\MarketRepository;

use Illuminate\Http\Request;
use Modules\Wallet\Enums\TypeTransactionActionEnum;

class PublicController extends BasePublicController
{
    /**
     * @var Application
     */
    private $app;
    private $marketRepository;
    // private $customerRepository;
    // private $customerCodeRepository;
    // private $walletRepository;
    // private $currencyRepository;
    // private $blockchainRepository;
    // private $transactionRepository;

    public function __construct(
        Application $app,
        MarketRepository $marketRepository,
        // CustomerRepository $customerRepository,
        // CustomerCodeRepository $customerCodeRepository,
        // WalletRepository $walletRepository,
        // CurrencyRepository $currencyRepository,
        // BlockchainRepository $blockchainRepository,
        // TransactionRepository $transactionRepository,
    ) {
        parent::__construct();
        $this->app = $app;
        $this->marketRepository = $marketRepository;
        // $this->customerRepository = $customerRepository;
        // $this->customerCodeRepository = $customerCodeRepository;
        // $this->walletRepository = $walletRepository;
        // $this->currencyRepository = $currencyRepository;
        // $this->blockchainRepository = $blockchainRepository;
        // $this->transactionRepository = $transactionRepository;
    }

    public function getTradingPairsList()
    {
        try {
            // $customerID = 40; //auth()->guard('customer');
            $marketPairs = $this->marketRepository->all();
            return view('spot-trades.trading-pairs-list', compact('marketPairs'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getTradingPair($symbol)
    {
        try {
            if (!auth()->guard('customer')->check()) {
                return redirect()->route('fe.customer.customer.login');
            }
            return view('spot-trades.trading-pair', compact('symbol'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function getFakePrice()
    {
        return response()->json([
            "MetaViral/USDT" => [
                "price" => 0.5,
                "up" => 0.03,
                "down" => 0.01
            ]
        ]);
    }
}
