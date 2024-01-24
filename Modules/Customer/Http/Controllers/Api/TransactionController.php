<?php

namespace Modules\Customer\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Customer\Http\Requests\CreateTransactionRequest;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Transformers\Transactions\TransactionTransformer;
use Modules\Customer\Entities\Customer;

class TransactionController extends BaseApiController
{
    private $transactionRepository;
    private $currencyRepository;
    private $walletRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        CurrencyRepository $currencyRepository,
        WalletRepository $walletRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->currencyRepository = $currencyRepository;
        $this->walletRepository = $walletRepository;
    }

    public function getListTransactions(Customer $customer, Request $request) {
        $transactions = $this->transactionRepository->getListTransactionCustomerAdmin($customer->id, $request);
        return TransactionTransformer::collection($transactions);
    }

    public function deposit(Customer $customer, CreateTransactionRequest $request) {
        try {
            $adminId = auth()->user()->id;
            $requestData = $request->all();
            if($requestData['amount'] <= 0) {
                return $this->respondWithError(trans('wallet::wallets.messages.amount_invalid'));
            }
            $action = $requestData['action'];
            $currency = $this->currencyRepository->findByAttributes([
                'id' => $requestData['currency_id']
            ]);
            $wallet = $this->walletRepository->findByAttributes([
                'customer_id' => $customer->id,
                'currency_id' => $requestData['currency_id']
            ]);
            if(!$wallet) {
                $dataCreate = [
                    'customer_id' =>  $customer->id,
                    'currency_id' => $requestData['currency_id'],
                    'type' => 'CRYPTO',
                    'balance' => 0,
                    'status' => true,
                ];
                $wallet = $this->walletRepository->create($dataCreate);
            }
            $newBalance = $wallet->balance + $requestData['amount'];
            $dataCreate = [
                'customer_id' => $customer->id,
                'currency_id' => $requestData['currency_id'],
                'blockchain_id' => null,
                'action' => TypeTransactionActionEnum::DEPOSIT,
                'amount' => $requestData['amount'],
                'amount_usd' => $requestData['amount'] * $currency->usd_rate,
                'fee' => 0,
                'balance' => $newBalance,
                'balanceBefore' => $wallet->balance,
                'payment_method' => 'CRYPTO',
                'txhash' => random_strings(30),
                'from' => "",
                'to' => "",
                'tag' => null,
                'order' => 0,
                'note' => $requestData['note'],
                'status' => StatusTransactionEnum::COMPLETED,
                'created_by' => $adminId
            ];
            $this->transactionRepository->create($dataCreate);
            event(new UpdateBalanceWallet($newBalance, $wallet->id));
            return $this->respondWithSuccess(trans("wallet::transactions.messages.transaction created"));
        } catch (\Exception $e) {
            \Log::channel('deposit')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function withdraw(Customer $customer, CreateTransactionRequest $request) {
        try {
            $adminId = auth()->user()->id;
            $requestData = $request->all();
            if($requestData['amount'] <= 0) {
                return $this->respondWithError(trans('wallet::wallets.messages.amount_invalid'));
            }
            $action = $requestData['action'];
            $currency = $this->currencyRepository->findByAttributes([
                'id' => $requestData['currency_id']
            ]);
            $wallet = $this->walletRepository->findByAttributes([
                'customer_id' => $customer->id,
                'currency_id' => $requestData['currency_id']
            ]);
            if(!$wallet) {
                $dataCreate = [
                    'customer_id' =>  $customer->id,
                    'currency_id' => $requestData['currency_id'],
                    'type' => 'CRYPTO',
                    'balance' => 0,
                    'status' => true,
                ];
                $wallet = $this->walletRepository->create($dataCreate);
            }
            if ($wallet->balance == 0 || $wallet->balance < $requestData['amount']) {
                return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
            }
            $newBalance = $wallet->balance - $requestData['amount'];
            $dataCreate = [
                'customer_id' => $customer->id,
                'currency_id' => $requestData['currency_id'],
                'blockchain_id' => null,
                'action' => TypeTransactionActionEnum::WITHDRAW,
                'amount' => $requestData['amount'],
                'amount_usd' => $requestData['amount'] * $currency->usd_rate,
                'fee' => 0,
                'balance' => $newBalance,
                'balanceBefore' => $wallet->balance,
                'payment_method' => 'CRYPTO',
                'txhash' => random_strings(30),
                'from' => "",
                'to' => "",
                'tag' => null,
                'order' => 0,
                'note' => $requestData['note'],
                'status' => StatusTransactionEnum::COMPLETED,
                'created_by' => $adminId
            ];
            $this->transactionRepository->create($dataCreate);
            event(new UpdateBalanceWallet($newBalance, $wallet->id));
            return $this->respondWithSuccess(trans("wallet::transactions.messages.transaction created"));
        } catch (\Exception $e) {
            \Log::channel('deposit')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }
}
