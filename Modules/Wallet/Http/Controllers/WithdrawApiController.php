<?php

namespace Modules\Wallet\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Customer\Enums\TypeEmailEnum;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Jobs\JobSendWithdrawCode;
use Modules\Wallet\Jobs\JobSyncWalletAddress;
use Modules\Wallet\Jobs\JobWithdrawSender;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Repositories\TransactionCodeRepository;
use Modules\Wallet\Transformers\CurrencyAttrs\BlockchainCurrencyAttrTransformer;
use Modules\Wallet\Transformers\Currencies\FullCurrencyTransformer;
use Modules\Wallet\Transformers\Transactions\ListWithdrawTransformer;

class WithdrawApiController extends BaseApiController
{
    protected $currencyRepository;
    protected $currencyAttrRepository;
    protected $walletRepository;
    protected $walletChainRepository;
    protected $transactionRepository;
    protected $blockchainRepository;
    protected $transactionCodeRepository;
    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyAttrRepository $currencyAttrRepository,
        WalletRepository $walletRepository,
        WalletChainRepository $walletChainRepository,
        TransactionRepository $transactionRepository,
        BlockchainRepository $blockchainRepository,
        TransactionCodeRepository $transactionCodeRepository
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->currencyAttrRepository = $currencyAttrRepository;
        $this->walletRepository = $walletRepository;
        $this->walletChainRepository = $walletChainRepository;
        $this->transactionRepository = $transactionRepository;
        $this->blockchainRepository = $blockchainRepository;
        $this->transactionCodeRepository = $transactionCodeRepository;
    }

    public function listWithdraw(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        $transactions = $this->transactionRepository->getListTransaction($customer->id, TypeTransactionActionEnum::WITHDRAW, $request);
        return $this->respondWithData([
            'transactions' => ListWithdrawTransformer::collection($transactions),
            'meta' => [
                'current_page' => $transactions->currentPage(),
                'per_page' => $transactions->perPage(),
                'total' => $transactions->total(),
                'totalPage' => ceil($transactions->total() / $transactions->perPage())
            ]
        ]);
    }

    private function validateWithdraw(array $data)
    {
        return Validator::make($data, [
            'blockchain_id' => ['required'],
            'currency_id' => ['required'],
            'address' => ['required', 'string'],
            'amount' => ['required'],
        ]);
    }

    public function withdraw(Request $request)
    {
        try {
            $data = $request->all();
            $validator = $this->validateWithdraw($request->all());
            if ($validator->fails()) {
                return $this->respondWithValidateError(trans('wallet::wallets.messages.validate_withdraw'), $validator->errors());
            }
            if (!isset($data['currency_id']) || !isset($data['blockchain_id'])) {
                return $this->respondWithError(trans('wallet::currenies.message.currency_not_found'));
            }
            $currency = $this->currencyRepository->find($data['currency_id']);
            if (!$currency) {
                return $this->respondWithError(trans('wallet::currenies.message.currency_not_found'));
            }

            $blockchain = $this->blockchainRepository->find($data['blockchain_id']);
            if (!$blockchain) {
                return $this->respondWithError(trans('wallet::blockchains.message.blockchain_not_found'));
            }

            $currencyAttr = $this->currencyAttrRepository->findByAttributes(['blockchain_id' =>  $blockchain->id, 'currency_id' => $currency->id]);
            if (!$currencyAttr || $currencyAttr->type_withdraw != 'ONCHAIN') {
                return $this->respondWithError(trans('wallet::transactions.message.blockchain_not_support'));
            }

            $customer = auth()->guard('customer')->user();
            $checkWallet = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $data['currency_id']]);
            if ($checkWallet) {
                if ($checkWallet->balance == 0 || $checkWallet->balance < $data['amount']) {
                    return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                }
                $newBalance = $checkWallet->balance - $data['amount'];
                event(new UpdateBalanceWallet($newBalance, $checkWallet->id));
                $fee = 0;
                if ($currencyAttr->withdraw_fee_token > 0) {
                    $fee = $currencyAttr->withdraw_fee_token;
                    if ($currencyAttr->withdraw_fee_token_type == 1) {
                        $fee = ($data['amount'] * $currencyAttr->withdraw_fee_token) / 100;
                    }
                }
                $dataCreate = [
                    'customer_id' => $customer->id,
                    'currency_id' => $data['currency_id'],
                    'blockchain_id' => $data['blockchain_id'],
                    'action' => TypeTransactionActionEnum::WITHDRAW,
                    'amount' => $data['amount'],
                    'amount_usd' => $data['amount'] * $currency->usd_rate,
                    'fee' => $fee,
                    'balance' => $newBalance,
                    'balanceBefore' => $checkWallet->balance,
                    'payment_method' => 'CRYPTO',
                    'txhash' => random_strings(30),
                    'from' => "",
                    'to' => $data['address'],
                    'tag' => null,
                    'order' => null,
                    'note' => null,
                    'status' => StatusTransactionEnum::CREATED
                ];
                $transaction = $this->transactionRepository->create($dataCreate);
                JobSendWithdrawCode::dispatch($customer, $transaction);
                return $this->respondWithData(['transaction' => $transaction]);
            } else {
                return $this->respondWithError(trans('wallet::wallets.messages.wallet_not_found'));
            }
        } catch (\Exception $e) {
            \Log::channel('withdraw')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function verifyWithdraw(Request $request)
    {
        try {
            $data = $request->all();
            if (isset($data['code']) && isset($data['transactionId'])) {
                $customer = auth()->guard('customer')->user();
                $transaction = $this->transactionRepository->findByAttributes(['id' => $data['transactionId'], 'customer_id' => $customer->id, 'status' => StatusTransactionEnum::CREATED]);
                if ($transaction) {
                    $code = $this->transactionCodeRepository->findByAttributes(
                        [
                            'transaction_id' => $transaction->id,
                            'code' => $request->get('code'),
                            'type' => TypeEmailEnum::WITHDRAW
                        ]
                    );
                    if ($code) {
                        $now = now();
                        $expired_at = Carbon::parse($code->expired_at);
                        DB::table('wallet__transactioncodes')
                            ->where('type', TypeEmailEnum::WITHDRAW)
                            ->where('transaction_id', $transaction->id)
                            ->delete();
                        if ($now > $expired_at) {
                            JobSendWithdrawCode::dispatch($customer, $transaction);
                            return $this->respondWithError(trans('wallet::transactions.messages.verify_code_expired'));
                        } else {
                            $currency = $transaction->currency;
                            $blockchain = $transaction->blockchain;
                            $checkApprove = $this->handleApproveTransaction($transaction, $currency, $blockchain, $customer);
                            $this->transactionRepository->update($transaction, ['status' => StatusTransactionEnum::ACCEPTED]);
                            if (!$checkApprove) {
                                JobWithdrawSender::dispatch($transaction);
                            }
                            return $this->respondWithSuccess(['message' => trans('wallet::transactions.messages.verify_code_transaction_success')]);
                        }
                    } else {
                        JobSendWithdrawCode::dispatch($customer, $transaction);
                        return $this->respondWithError(trans('wallet::transactions.messages.verify_code_expired'));
                    }
                } else {
                    return $this->respondWithError(trans('wallet::transactions.messages.transaction_not_found'));
                }
            } else {
                return $this->respondWithError(trans('wallet::transactions.messages.validate_verify_code'));
            }
        } catch (\Exception $e) {
            \Log::channel('withdraw')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function resendVerifyCodeWithdraw(Request $request)
    {
        try {
            $data = $request->all();
            if (isset($data['transactionId'])) {
                $customer = auth()->guard('customer')->user();
                $transaction = $this->transactionRepository->findByAttributes(['id' => $data['transactionId'], 'customer_id' => $customer->id, 'status' => StatusTransactionEnum::CREATED]);
                if ($transaction) {
                    $code = $this->transactionCodeRepository->findByAttributes(
                        [
                            'transaction_id' => $transaction->id,
                            'type' => TypeEmailEnum::WITHDRAW
                        ]
                    );
                    if ($code) {
                        $now = now();
                        $expired_at = Carbon::parse($code->expired_at);
                        if ($now > $expired_at) {
                            DB::table('wallet__transactioncodes')
                                ->where('type', TypeEmailEnum::WITHDRAW)
                                ->where('transaction_id', $transaction->id)
                                ->delete();
                            JobSendWithdrawCode::dispatch($customer, $transaction);
                        }
                    } else {
                        JobSendWithdrawCode::dispatch($customer, $transaction);
                    }
                    return $this->respondWithSuccess(['message' => trans('wallet::transactions.messages.resend_verify_code_success')]);
                } else {
                    return $this->respondWithError(trans('wallet::transactions.messages.transaction_not_found'));
                }
            } else {
                return $this->respondWithError(trans('wallet::transactions.messages.validate_verify_code'));
            }
        } catch (\Exception $e) {
            \Log::channel('withdraw')->error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    private function handleApproveTransaction($transaction, $currency, $blockchain, $customer)
    {
        try {
            $currencyAttr = $this->currencyAttrRepository->findByAttributes([
                'blockchain_id' => $blockchain->id,
                'currency_id' => $currency->id
            ]);
            if (!$currencyAttr) {
                return true;
            }
            $max_times_withdraw = $currencyAttr->max_times_withdraw;
            $value_need_approve = $currencyAttr->value_need_approve;
            $max_amount_withdraw_daily = $currencyAttr->max_amount_withdraw_daily;
            if ($transaction->amount >  $value_need_approve) {
                return true;
            }
            $transactions = $this->transactionRepository->getWithdrawInDay($currency->id, $customer->id);
            if ($transactions->count() > $max_times_withdraw) {
                return true;
            }

            if ($transactions->sum('amount') > $max_amount_withdraw_daily) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::channel('withdraw')->error($e->getMessage());
            return true;
        }
    }
}
