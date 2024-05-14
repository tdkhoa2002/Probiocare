<?php

namespace Modules\Customer\Events;

use Modules\Customer\Entities\PaymentMethod;

class PaymentMethodWasDeleted
{
    /**
     * @var PaymentMethod
     */
    public $PaymentMethod;

    public function __construct($PaymentMethod)
    {
        $this->PaymentMethod = $PaymentMethod;
    }
}
