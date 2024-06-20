<?php

namespace Modules\Customer\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailCancelOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $orderId;
    public function __construct($customer, $orderId)
    {
        $this->customer = $customer;
        $this->orderId = $orderId;
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
        return $this->view('customer::customers.emails.send-email-cancel-order')->subject($siteName . " - Order Cancel.");
    }
}
