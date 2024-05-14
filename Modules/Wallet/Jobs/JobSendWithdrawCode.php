<?php

namespace Modules\Wallet\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Enums\TypeEmailEnum;
use Modules\Wallet\Emails\SendWithdrawCode;
use Modules\Wallet\Repositories\TransactionCodeRepository;

class JobSendWithdrawCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $customer;
    public $transaction;
    public function __construct($customer, $transaction)
    {
        $this->customer = $customer;
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
            $code = random_number(6);
            app(TransactionCodeRepository::class)->create([
                'transaction_id' => $this->transaction->id,
                'code' => $code,
                'type' => TypeEmailEnum::WITHDRAW,
                'expired_at' => now()->addMinute(10)
            ]);
            $email = new SendWithdrawCode($this->customer, $this->transaction, $code);
            Mail::to($this->customer->email)->send($email);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
        }
    }
}
