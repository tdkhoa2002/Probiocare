<?php

namespace Modules\Customer\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Customer\Entities\PaymentMethod;

class PaymentMethodWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var PaymentMethod
     */
    public $PaymentMethod;

    public function __construct(PaymentMethod $PaymentMethod, array $data)
    {
        $this->data = $data;
        $this->PaymentMethod = $PaymentMethod;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->PaymentMethod;
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
