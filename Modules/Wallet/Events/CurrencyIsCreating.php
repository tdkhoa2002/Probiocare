<?php

namespace Modules\Wallet\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;

class CurrencyIsCreating extends AbstractEntityHook implements EntityIsChanging
{
}
