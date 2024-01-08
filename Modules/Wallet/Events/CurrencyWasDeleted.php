<?php

namespace Modules\Wallet\Events;

use Modules\Wallet\Entities\Currency;

class CurrencyWasDeleted
{
    /**
     * @var Currency
     */
    public $Currency;

    public function __construct($Currency)
    {
        $this->Currency = $Currency;
    }
}
