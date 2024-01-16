<?php

namespace Modules\Loyalty\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;

class PackageIsCreating extends AbstractEntityHook implements EntityIsChanging
{
}