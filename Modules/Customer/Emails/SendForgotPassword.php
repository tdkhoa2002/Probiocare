<?php

namespace Modules\Customer\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $code;
    public function __construct($customer, $code)
    {
        $this->customer = $customer;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $siteName = setting("core::site-name");
        \Log::info($siteName);
        if (themeOption(setting('core::template', null, '') . '::site-name') != null) {
            $siteName = themeOption(setting('core::template', null, '') . '::site-name');
        }
        \Log::info($siteName);
        return $this->view('customer::customers.emails.send-code-forgot-password')->subject($siteName . " - Verify Forgot Password");
    }
}
