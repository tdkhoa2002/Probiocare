<?php

namespace Modules\Wallet\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Modules\Setting\Facades\Settings;
use Modules\Wallet\Entities\ChainWallet;
use Modules\Wallet\Entities\WalletChain;
use Modules\Wallet\Repositories\ChainWalletRepository;

class JobSendFeeClaim implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $blockchain;
    public $address;
    public $decimal;
    public function __construct($blockchain, $address, $decimal)
    {
        $this->address = $address;
        $this->blockchain = $blockchain;
        $this->decimal = $decimal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $chainWallet = app(ChainWalletRepository::class)->findChainWalletAvaliable($this->blockchain->id);
            if ($chainWallet) {
                app(ChainWalletRepository::class)->update($chainWallet, ['using' => true]);
                $urlApi = config('wallet.api_withdraw_wallet');
                $ownerPrivateKey = decodeString($chainWallet->private_key);
                $response = Http::post($urlApi, [
                    'contract' => "",
                    'toAddress' => $this->address,
                    'ownerAddress' =>  $chainWallet->address,
                    'ownerPrivateKey' => $ownerPrivateKey,
                    "amount" => 0.001,
                    "rpc" => $this->blockchain->rpc,
                    "decimal" =>  $this->decimal
                ]);
                if ($response->successful()) {
                    app(ChainWalletRepository::class)->update($chainWallet, ['using' => false]);
                    return true;
                } else {
                    return false;
                }
            } else {
                JobSendFeeClaim::dispatch($this->blockchain, $this->address, $this->decimal)->delay(now()->addMinutes(1));
            }
        } catch (\Exception $e) {
            \Log::error('JobSendFeeClaim:', $e->getMessage());
            return false;
        }
    }
}
