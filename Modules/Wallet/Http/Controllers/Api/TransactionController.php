<?php

namespace Modules\Wallet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Wallet\Entities\Transaction;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Http\Requests\CreateTransactionRequest;
use Modules\Wallet\Http\Requests\UpdateTransactionRequest;
use Modules\Wallet\Jobs\JobWithdrawSender;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Wallet\Transformers\Transactions\FullTransactionTransformer;
use Modules\Wallet\Transformers\Transactions\TransactionTransformer;
use Modules\Wallet\Repositories\WalletRepository;

class TransactionController extends Controller
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    private $walletRepository;

    public function __construct(TransactionRepository $transactionRepository, WalletRepository $walletRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
    }

    public function all()
    {
        return FullTransactionTransformer::collection($this->transactionRepository->all());
    }

    public function indexServerSide(Request $request)
    {
        return TransactionTransformer::collection($this->transactionRepository->serverPaginationFilteringFor($request));
    }

    public function store(CreateTransactionRequest $request)
    {
        $this->transactionRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('wallet::transactions.messages.transaction created'),
        ]);
    }

    public function find($transactionId)
    {
        $transaction = $this->transactionRepository->find($transactionId);
        return new FullTransactionTransformer($transaction);
    }

    public function update(Transaction $transaction, UpdateTransactionRequest $request)
    {
        $this->transactionRepository->update($transaction, $request->all());
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::transactions.messages.transaction updated'),
        ]);
    }

    public function destroy(Transaction $transaction)
    {
        $this->transactionRepository->destroy($transaction);
        return response()->json([
            'errors' => false,
            'message' => trans('wallet::transactions.messages.transaction deleted'),
        ]);
    }

    public function resendWithdraw(Transaction $transaction)
    {
        try {
            if ($transaction->action == 'WITHDRAW' && in_array($transaction->status, ['ACCEPTED', 'CREATED', 'FAIL'])) {
                JobWithdrawSender::dispatch($transaction);
                return response()->json([
                    'errors' => false,
                    'message' => trans('wallet::transactions.messages.transaction_resend_withdraw_proccessing'),
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'message' => trans('wallet::transactions.messages.transaction_cant_resend_withdraw'),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errors' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function cancelWithdraw(Transaction $transaction)
    {
        try {
            if ($transaction->action == 'WITHDRAW' && in_array($transaction->status, ['ACCEPTED', 'CREATED', 'FAIL'])) {
                $this->transactionRepository->update($transaction, ['status' => StatusTransactionEnum::CANCELED]);
                $wallet = $this->walletRepository->where("customer_id", $transaction->customer_id)->where("currency_id",  $transaction->currency_id)->first();
                $currency = $transaction->currency;
                $newBalance = $wallet->balance + $transaction->amount;
                $dataCreate = [
                    'customer_id' => $transaction->customer_id,
                    'currency_id' => $transaction->currency_id,
                    'blockchain_id' => null,
                    'action' => TypeTransactionActionEnum::RETURN,
                    'amount' => $transaction->amount,
                    'amount_usd' => $transaction->amount * $currency->usd_rate,
                    'fee' => 0,
                    'balance' => $newBalance,
                    'balanceBefore' => $wallet->balance,
                    'payment_method' => 'CRYPTO',
                    'txhash' => random_strings(30),
                    'from' => "",
                    'to' => "",
                    'tag' => null,
                    'order' => null,
                    'note' => null,
                    'status' => StatusTransactionEnum::COMPLETED
                ];

                event(new CreateTransaction($dataCreate));
                event(new UpdateBalanceWallet($newBalance, $wallet->id));
                return response()->json([
                    'errors' => false,
                    'message' => trans('wallet::transactions.messages.transaction_cancel_success'),
                ]);
            } else {
                return response()->json([
                    'errors' => true,
                    'message' => trans('wallet::transactions.messages.transaction_cant_cancel'),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'errors' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getStaticTransaction(){
        return response()->json([
            'errors' => false,
            'actions' => TypeTransactionActionEnum::cases(),
            'status' => StatusTransactionEnum::cases(),
        ]);
    }
}
