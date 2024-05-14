<?php

namespace Modules\Wallet\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Wallet\Entities\Currency;

class CurrencyWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Currency
     */
    public $Currency;

    public function __construct(Currency $Currency, array $data)
    {
        $this->data = $data;
        $this->Currency = $Currency;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->Currency;
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
