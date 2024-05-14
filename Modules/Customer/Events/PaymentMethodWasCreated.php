<?php

namespace Modules\Customer\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Customer\Entities\PaymentMethod;

class PaymentMethodWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var PaymentMethod
     */
    public $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod, array $data)
    {
        $this->data = $data;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->paymentMethod;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
