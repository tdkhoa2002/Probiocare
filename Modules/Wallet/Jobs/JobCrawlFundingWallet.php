<?php

namespace Modules\Wallet\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Modules\Wallet\Events\CreateCrawlHistory;
use Modules\Wallet\Events\ResetOnHoldWalletChain;
use Modules\Wallet\Events\UpdateTotalCrawlDeposit;
use Modules\Wallet\Repositories\ChainWalletRepository;
use Modules\Wallet\Repositories\CrawlHistoryRepository;

class JobCrawlFundingWallet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $toAddress;
    public $walletId;
    public $ownerAddress;
    public $ownerPrivateKey;
    public $amount;
    public $rpc;
    public $decimal;
    public $token_address;
    public $crawlDepositId;
    public function __construct($crawlDepositId, $token_address, $walletId, $toAddress, $ownerAddress, $ownerPrivateKey, $amount, $rpc, $decimal)
    {
        $this->toAddress = $toAddress;
        $this->ownerAddress = $ownerAddress;
        $this->ownerPrivateKey = $ownerPrivateKey;
        $this->amount = $amount;
        $this->rpc = $rpc;
        $this->decimal = $decimal;
        $this->walletId = $walletId;
        $this->token_address = $token_address;
        $this->crawlDepositId = $crawlDepositId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $urlApi = config('wallet.api_withdraw_wallet');
            $amount = $this->amount;
            if ($this->token_address == null || $this->token_address == "") {
                $amount = $amount - 0.001;
            }
            $response = Http::post($urlApi, [
                'contract' => $this->token_address == null ? "" : $this->token_address,
                'toAddress' => $this->toAddress,
                'ownerAddress' =>  $this->ownerAddress,
                'ownerPrivateKey' => $this->ownerPrivateKey,
                "amount" => $this->amount,
                "rpc" => $this->rpc,
                "decimal" =>  $this->decimal
            ]);
            if ($response->successful()) {
                $response = $response->json();
                if (isset($response['error']) && $response['error'] == false) {
                    event(new ResetOnHoldWalletChain($this->walletId));
                    $dataCreate = [
                        'walletchain_id' => $this->walletId,
                        'crawldeposit_id' => $this->crawlDepositId,
                        'amount' => $this->amount,
                        'txhash' => $response['data']['transactionHash'],
                    ];
                    \Log::channel('crawlFund')->error($dataCreate);
                    event(new CreateCrawlHistory($dataCreate));
                    event(new UpdateTotalCrawlDeposit($this->crawlDepositId, $this->amount));
                } else {
                    \Log::channel('crawlFund')->error($response);
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            \Log::channel('crawlFund')->error($e->getMessage());
            return false;
        }
    }
}
