<?php

namespace Modules\Customer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Emails\SendEmailCancelOrder;
use Modules\Customer\Enums\TypeEmailEnum;

class JobSendEmailOrderCancel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $customer;
    public $orderId;
    public function __construct($customer, $orderId)
    {
        $this->customer = $customer;
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $email = new SendEmailCancelOrder($this->customer, $this->orderId);
            Mail::to($this->customer->email)->send($email);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
