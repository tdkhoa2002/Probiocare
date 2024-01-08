<?php

namespace Modules\Wallet\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Modules\Wallet\Repositories\CurrencyAttrRepository;
use Modules\Wallet\Enums\StatusTransactionEnum;
use Modules\Wallet\Enums\TypeTransactionActionEnum;
use Modules\Wallet\Events\CreateTransaction;
use Modules\Wallet\Events\UpdateBalanceWallet;
use Modules\Wallet\Events\UpdateTransaction;
use Modules\Wallet\Repositories\ChainWalletRepository;
use Modules\Wallet\Repositories\WalletChainRepository;
use Modules\Wallet\Repositories\WalletRepository;

class JobWithdrawSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $transaction;
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $blockchain = $this->transaction->blockchain;
            $currency = $this->transaction->currency;
            $currencyAttr = app(CurrencyAttrRepository::class)->findByAttributes(['blockchain_id' =>  $blockchain->id, 'currency_id' => $currency->id]);
            if ($currencyAttr) {
                $amount = $this->transaction->amount - $this->transaction->fee;
                $decimal = $currencyAttr->decimal;
                $chainWallet = app(ChainWalletRepository::class)->findChainWalletAvaliable($blockchain->id);
                $checkIntenalWallet = app(WalletChainRepository::class)->findWalletByAddressAndCurrency($this->transaction->to, $currency->id);
                if ($checkIntenalWallet && $currencyAttr->type_transfer == 'INTERNAL_TRANSFER') {
                    // ToDo: fix find wallet by currency
                    $wallet = app(WalletRepository::class)->find($checkIntenalWallet->wallet_id);
                    $hash = 'INTERNAL-' . random_strings(20);
                    $newBalance = $wallet->balance + $amount;
                    $transaction = [
                        'customer_id' => $wallet->customer_id,
                        'currency_id' => $currencyAttr->currency_id,
                        'blockchain_id' => $currencyAttr->blockchain_id,
                        'action' => TypeTransactionActionEnum::DEPOSIT,
                        'amount' =>  $amount,
                        'amount_usd' =>  $amount * $currency->usd_rate,
                        'fee' => 0,
                        'balance' => $newBalance,
                        'balanceBefore' => $wallet->balance,
                        'payment_method' => 'CRYPTO',
                        'txhash' => $hash,
                        'from' => $this->transaction->from,
                        'to' => $this->transaction->to,
                        'tag' => "",
                        'order' => $this->transaction->id,
                        'note' => "",
                        'status' => StatusTransactionEnum::COMPLETED
                    ];

                    event(new CreateTransaction($transaction));
                    event(new UpdateBalanceWallet($newBalance, $wallet->id));
                    event(new UpdateTransaction($this->transaction->id, [
                        'status' => StatusTransactionEnum::COMPLETED,
                        'txhash' => $hash
                    ]));
                    return true;
                } else {
                    if ($chainWallet) {
                        app(ChainWalletRepository::class)->update($chainWallet, ['using' => true]);
                        $urlApi = config('wallet.api_withdraw_wallet');
                        $ownerPrivateKey = decodeString($chainWallet->private_key);
                        event(new UpdateTransaction($this->transaction->id, ['status' => StatusTransactionEnum::PROCESSING]));
                        $response = Http::post($urlApi, [
                            'contract' => $currencyAttr->token_address != null ? $currencyAttr->token_address : "",
                            'toAddress' => $this->transaction->to,
                            'ownerAddress' =>  $chainWallet->address,
                            'ownerPrivateKey' => $ownerPrivateKey,
                            "amount" => $amount,
                            "rpc" => $blockchain->rpc,
                            "decimal" =>  $decimal
                        ]);
                        if ($response->successful()) {
                            app(ChainWalletRepository::class)->update($chainWallet, ['using' => false]);
                            $response = $response->json();
                            if (isset($response['error']) && $response['error'] == false) {
                                event(new UpdateTransaction($this->transaction->id, [
                                    'status' => StatusTransactionEnum::COMPLETED,
                                    'txhash' => $response['data']['transactionHash']
                                ]));
                            } else {
                                event(new UpdateTransaction($this->transaction->id, ['status' => StatusTransactionEnum::FAIL]));
                                \Log::channel('withdraw')->info($response);
                            }
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        JobWithdrawSender::dispatch($this->transaction)->delay(now()->addMinute(1));
                        return false;
                    }
                }
            } else {
                \Log::channel('withdraw')->error("currencyAttr not found");
            }
        } catch (\Throwable $e) {
            \Log::channel('withdraw')->error($e->getMessage());
        }
    }
}
