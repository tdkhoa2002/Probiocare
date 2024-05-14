<?php

namespace Modules\Wallet\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;
use Modules\Setting\Facades\Settings;
use Modules\Wallet\Entities\WalletChain;

class JobSyncWalletAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $address;
    public $chainCode;
    public $blockchainId;
    public function __construct($address, $chainCode, $blockchainId)
    {
        $this->address = $address;
        $this->chainCode = $chainCode;
        $this->blockchainId = $blockchainId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $url = config('evmTracker.api_sync_address_evm_tracker');
            $apiKey = Settings::get('wallet::api_key_evm_tracker');
            if ($url != null && $apiKey != null) {
                $response = Http::post($url, [
                    'address' => [$this->address],
                    'chain_code' => $this->chainCode,
                    "transaction_watcher" => "TO",
                    "api_key" => $apiKey
                ]);
                if ($response->successful()) {
                    $response = $response->json();
                    if (isset($response['status']) && $response['status'] == 'success') {
                        WalletChain::where('address', $this->address)->where('blockchain_id', $this->blockchainId)->update(['is_sync' => true]);
                    }
                    return true;
                } else {
                    return false;
                }
            }
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
        }
    }
}
