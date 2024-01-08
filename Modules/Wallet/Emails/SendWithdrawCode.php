<?php

namespace Modules\Wallet\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWithdrawCode extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $transaction;
    public $code;
    public function __construct($customer, $transaction, $code)
    {
        $this->customer = $customer;
        $this->code = $code;
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $siteName = setting("core::site-name");
        return $this->view('wallet::transactions.emails.send-code-withdraw')->subject($siteName . ' - Withdrawal Request Verification!');
    }
}
