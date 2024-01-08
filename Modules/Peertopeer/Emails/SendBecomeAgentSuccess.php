<?php

namespace Modules\Peertopeer\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBecomeAgentSuccess extends Mailable
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
        return $this->view('peertopeer::emails.become-agent-success')->subject('Congratulation to become P2P Agent!');
    }
}
