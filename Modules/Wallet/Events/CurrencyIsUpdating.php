<?php

namespace Modules\Wallet\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;
use Modules\Wallet\Entities\Currency;

class CurrencyIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
    /**
     * @var Currency
     */
    private $Currency;

    public function __construct(Currency $Currency, array $attributes)
    {
        $this->Currency = $Currency;
        parent::__construct($attributes);
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->Currency;
    }
}
