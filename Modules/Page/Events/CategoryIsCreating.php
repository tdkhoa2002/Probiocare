<?php

namespace Modules\Page\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;

class CategoryIsCreating extends AbstractEntityHook implements EntityIsChanging
{
}
