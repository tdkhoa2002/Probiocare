<?php

namespace Modules\Customer\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerifiedCodeSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $siteName = setting("core::site-name");
        if (themeOption(setting('core::template', null, '') . '::site-name') != null) {
            $siteName = themeOption(setting('core::template', null, '') . '::site-name');
        }
        return $this->view('customer::customers.verify-code-success')->subject('Welcome to '. $siteName.'!');
    }
}
