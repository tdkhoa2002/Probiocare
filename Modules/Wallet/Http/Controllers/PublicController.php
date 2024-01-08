<?php

namespace Modules\Wallet\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Modules\Wallet\Enums\TypeTransactionActionEnum;

class PublicController extends BasePublicController
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

    public function index()
    {
        try {
            $customerID = auth()->guard('customer')->user()->id;
            $wallets = $this->walletRepository->where("customer_id", $customerID)->get();
            $currencies = $this->currencyRepository->getByAttributes(['type' => 'CRYPTO', 'status' => true]);
            return view('wallets.wallet-list', compact('wallets', 'currencies'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function deposit(Request $request)
    {
        try {
            $sellected = $request->currency;
            $customerID = auth()->guard('customer')->user()->id;
            $transactions = $this->transactionRepository->getListTransaction($customerID, TypeTransactionActionEnum::DEPOSIT, $request);
            $currencySelected = $this->currencyRepository->findByAttributes(['code' => $request->get('currency')]);
            $currencyIdSelected = $currencySelected ? $currencySelected->id : 0;
            return view('wallets.wallet-deposit', compact('sellected', 'transactions', 'currencyIdSelected'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }

    public function withdraw(Request $request)
    {
        try {
            $sellected = $request->currency;
            $currencySelected = $this->currencyRepository->findByAttributes(['code' => $request->get('currency')]);
            $currencyIdSelected = $currencySelected ? $currencySelected->id : 0;
            return view('wallets.wallet-withdraw', compact('sellected', 'currencyIdSelected'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
    public function history(Request $request)
    {
        try {
            $customerID = auth()->guard('customer')->user()->id;
            $currencies = $this->currencyRepository->all();
            $blockchains = $this->blockchainRepository->all();
            $transactions = $this->transactionRepository->getListTransaction($customerID, "ALL", $request);
            $types = array_column(TypeTransactionActionEnum::cases(), 'value');
            return view('wallets.wallet-history', compact('currencies', 'blockchains', 'transactions', 'types'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return back();
        }
    }
}
