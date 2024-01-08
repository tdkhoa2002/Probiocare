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
use Modules\Wallet\Http\Requests\Frontend\CreateSwapRequest;
use Modules\Wallet\Jobs\JobSendWithdrawCode;
use Modules\Wallet\Jobs\JobSyncWalletAddress;
use Modules\Wallet\Repositories\CurrencyRepository;
use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Wallet\Repositories\TransactionRepository;
use Modules\Wallet\Repositories\BlockchainRepository;
use Modules\Wallet\Repositories\TransactionCodeRepository;
use Modules\Wallet\Transformers\CurrencyAttrs\BlockchainCurrencyAttrTransformer;
use Modules\Wallet\Transformers\Currencies\FullCurrencyTransformer;
use Modules\Wallet\Transformers\Currencies\SmallCurrencyTransformer;
use Modules\Wallet\Transformers\Transactions\ListWithdrawTransformer;

class PublicApiController extends BaseApiController
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

    public function getBlockchainSupport($currencyId)
    {
        $currency = $this->currencyRepository->find($currencyId);
        if ($currency) {
            $currencyAttrs = $this->currencyAttrRepository->getByAttributes(['currency_id' => $currencyId]);
            $blockchains = BlockchainCurrencyAttrTransformer::collection($currencyAttrs);
            $customer = auth()->guard('customer')->user();
            $checkWallet = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $currencyId]);
            return $this->respondWithData(['blockchains' => $blockchains, 'balance' => $checkWallet->balance ?? 0]);
        } else {
            return $this->respondWithError(trans('wallet::currenies.message.currency_not_found'));
        }
    }

    public function getAddress(Request $request)
    {
        try {
            $data = $request->all();
            if (!isset($data['currency_id']) || !isset($data['blockchain_id'])) {
                return $this->respondWithError(trans('wallet::currenies.message.currency_not_found'));
            }
            $customer = auth()->guard('customer')->user();
            $blockchain = $this->blockchainRepository->find($data['blockchain_id']);
            if (!$blockchain) {
                return $this->respondWithError(trans('wallet::blockchains.message.blockchain_not_found'));
            }
            // Find existing available web3 address or create new
            $dataAddress = $this->getAddressByChainCode($customer->id, $blockchain->type);
            if ($dataAddress) {
                $encodePrivateKey = $dataAddress->private_key;
                $address = $dataAddress->address;
            } else {
                $dataAddress = $this->getAddressEthereum();
                if (!$dataAddress) {
                    return $this->respondWithError(trans('wallet::wallets.messages.create_address_error_try_again'));
                }
                $address = $dataAddress['data']['address'];
                $encodePrivateKey = encodeString($dataAddress['data']['privateKey']);
            }
            // Check wallet is existed
            $checkWallet = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $data['currency_id']]);
            if ($checkWallet) {
                $walletChain = $this->walletChainRepository->findByAttributes(['wallet_id' => $checkWallet->id, 'blockchain_id' => $data['blockchain_id']]);
                if ($walletChain) {
                    return $this->respondWithData(['address' => $walletChain->address]);
                } else {
                    $walletChainSynced = $this->walletChainRepository->findByAttributes([
                        'address' => $address,
                        'blockchain_id' => $data['blockchain_id'],
                        'is_sync' => true
                    ]);
                    $dataCreateWallet = [
                        'wallet_id' => $checkWallet->id,
                        'blockchain_id' => $data['blockchain_id'],
                        'address' => $address,
                        'addressTag' => "",
                        'private_key' => $encodePrivateKey,
                        'onhold' => 0
                    ];
                    if ($walletChainSynced) {
                        $dataCreateWallet['is_sync'] = true;
                    } else {
                        $dataCreateWallet['is_sync'] = false;
                        JobSyncWalletAddress::dispatch($address, $blockchain->code, $blockchain->id);
                    }
                    $this->walletChainRepository->create($dataCreateWallet);
                    return $this->respondWithData(['address' => $address]);
                }
            } else {
                $dataCreate = [
                    'customer_id' => $customer->id,
                    'currency_id' => $data['currency_id'],
                    'type' => 'CRYPTO',
                    'balance' => 0,
                    'status' => true,
                ];
                $wallet = $this->walletRepository->create($dataCreate);
                if ($wallet) {
                    $walletChainSynced = $this->walletChainRepository->findByAttributes([
                        'address' => $address,
                        'blockchain_id' => $data['blockchain_id'],
                        'is_sync' => true
                    ]);
                    $dataCreateWallet = [
                        'wallet_id' => $wallet->id,
                        'blockchain_id' => $data['blockchain_id'],
                        'address' => $address,
                        'addressTag' => "",
                        'private_key' => $encodePrivateKey,
                        'onhold' => 0
                    ];
                    if ($walletChainSynced) {
                        $dataCreateWallet['is_sync'] = true;
                    } else {
                        $dataCreateWallet['is_sync'] = false;
                        JobSyncWalletAddress::dispatch($address, $blockchain->code, $blockchain->id);
                    }
                    $this->walletChainRepository->create($dataCreateWallet);
                    return $this->respondWithData(['address' => $address]);
                } else {
                    return $this->respondWithError(trans('wallet::currenies.message.currency_not_found'));
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    private function getAddressByChainCode($customerId, $chainType)
    {
        $blockchains = $this->blockchainRepository->getByAttributes(['type' => $chainType]);
        if ($blockchains->count() > 0) {
            $wallet = $this->walletChainRepository->findWalletChainByBlockchain($customerId, $blockchains->pluck('id')->toArray());
            if ($wallet) {
                return $wallet;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function getAddressEthereum()
    {
        $response = Http::acceptJson()->get(config('wallet.api_create_wallet'));
        if ($response->successful()) {
            return $response->json();
        } else {
            return false;
        }
    }

    public function getCurrencies()
    {
        try {
            $currencies = $this->currencyRepository->getByAttributes(['type' => "CRYPTO", 'status' => true]);
            return $this->respondWithData(['currencies' => SmallCurrencyTransformer::collection($currencies)]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getBalance($currencyId)
    {
        $currency = $this->currencyRepository->find($currencyId);
        if ($currency) {
            $customer = auth()->guard('customer')->user();
            $wallet = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $currencyId]);
            return $this->respondWithData(['balance' => $wallet->balance ?? 0]);
        } else {
            return $this->respondWithError(trans('wallet::currenies.messages.currency_not_found'));
        }
    }

    public function swap(CreateSwapRequest $request)
    {
        try {
            $customer = auth()->guard('customer')->user();
            $currencyFrom = $this->currencyRepository->find($request->get('from_currency_id'));
            $currencyTo = $this->currencyRepository->find($request->get('to_currency_id'));
            if ($currencyFrom && $currencyTo) {
                $walletFrom = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $currencyFrom->id]);
                if (!$walletFrom) {
                    return $this->respondWithError(trans('wallet::wallets.messages.wallet_not_found'));
                }

                $walletTo = $this->walletRepository->findByAttributes(['customer_id' => $customer->id, 'currency_id' => $currencyTo->id]);
                if (!$walletTo) {
                    $dataCreate = [
                        'customer_id' =>  $customer->id,
                        'currency_id' => $currencyTo->id,
                        'type' => 'CRYPTO',
                        'balance' => 0,
                        'status' => true,
                    ];
                    $walletTo = $this->walletRepository->create($dataCreate);
                }
                $amountfrom = $request->get('amount_from');
                if ($currencyFrom->min_swap <= $amountfrom && $currencyFrom->max_swap >= $amountfrom) {
                    if ($amountfrom < $walletFrom->balance) {
                        $fee = $currencyFrom->swap_fee;
                        if ($currencyFrom->swap_fee_type == 1) {
                            $fee = ($amountfrom * $currencyFrom->swap_fee) / 100;
                        }
                        $pricePair = $currencyFrom->usd_rate / $currencyTo->usd_rate;
                        $amountTo = ($amountfrom - $fee) * $pricePair;

                        $newBalanceFrom = $walletFrom->balance - $amountfrom;
                        event(new UpdateBalanceWallet($newBalanceFrom, $walletFrom->id));
                        $dataCreate = [
                            'customer_id' => $customer->id,
                            'currency_id' => $currencyFrom->id,
                            'blockchain_id' => null,
                            'action' => TypeTransactionActionEnum::SWAP_FROM,
                            'amount' => $amountfrom,
                            'amount_usd' => $amountfrom * $currencyFrom->usd_rate,
                            'fee' => $fee,
                            'balance' => $newBalanceFrom,
                            'balanceBefore' => $walletFrom->balance,
                            'payment_method' => 'CRYPTO',
                            'txhash' => random_strings(30),
                            'from' => "",
                            'to' => "",
                            'tag' => null,
                            'order' => null,
                            'note' => null,
                            'status' => StatusTransactionEnum::COMPLETED
                        ];
                        $this->transactionRepository->create($dataCreate);


                        $newBalanceTo = $walletTo->balance + $amountTo;
                        event(new UpdateBalanceWallet($newBalanceTo, $walletTo->id));
                        $dataCreateTo = [
                            'customer_id' => $customer->id,
                            'currency_id' => $currencyTo->id,
                            'blockchain_id' => null,
                            'action' => TypeTransactionActionEnum::SWAP_TO,
                            'amount' => $amountTo,
                            'amount_usd' => $amountTo * $currencyTo->usd_rate,
                            'fee' => $fee,
                            'balance' => $newBalanceTo,
                            'balanceBefore' => $walletTo->balance,
                            'payment_method' => 'CRYPTO',
                            'txhash' => random_strings(30),
                            'from' => "",
                            'to' => "",
                            'tag' => null,
                            'order' => null,
                            'note' => null,
                            'status' => StatusTransactionEnum::COMPLETED
                        ];
                        $this->transactionRepository->create($dataCreateTo);

                        return $this->respondWithSuccess(['message' => trans('wallet::wallets.messages.swap_success')]);
                    } else {
                        return $this->respondWithError(trans('wallet::wallets.messages.balance_dont_enough'));
                    }
                } else {
                    return $this->respondWithError(trans('wallet::wallets.messages.limit_swap', [
                        'min' => $currencyFrom->min_swap,
                        'max' => $currencyFrom->max_swap,
                        'code' => $currencyFrom->code,
                    ]));
                }
            } else {
                return $this->respondWithError(trans('wallet::currenies.messages.currency_not_found'));
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->respondWithError($e->getMessage());
        }
    }

    public function getRecentTransaction(Request $request)
    {
        $type = $request->get('type');
        if ($type == null) {
            return $this->respondWithSuccess(['transactions' => []]);
        } else {
            $customer = auth()->guard('customer')->user();
            $transactions = $this->transactionRepository->getListTransaction($customer->id, $type, $request);
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
    }
}
