<?php

namespace Modules\Customer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Emails\SendChangePassword;
use Modules\Customer\Enums\TypeEmailEnum;
use Modules\Customer\Repositories\CustomerCodeRepository;

class JobSendCodeChangePassword implements ShouldQueue
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
            $code = random_number(6);
            app(CustomerCodeRepository::class)->create([
                'customer_id' => $this->customer->id,
                'code' => $code,
                'type' => TypeEmailEnum::CHANGEPASSWORD,
                'expired_at' => now()->addMinute(10)
            ]);
            $email = new SendChangePassword($this->customer, $code);
            Mail::to($this->customer->email)->send($email);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
