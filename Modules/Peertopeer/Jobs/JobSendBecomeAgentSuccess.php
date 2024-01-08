<?php

namespace Modules\Peertopeer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Peertopeer\Emails\SendBecomeAgentSuccess;

class JobSendBecomeAgentSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $customer;
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $email = new SendBecomeAgentSuccess($this->customer);
            Mail::to($this->customer->email)->send($email);
        } catch (\Throwable $e) {
            \Log::error($e->getMessage());
        }
    }
}
