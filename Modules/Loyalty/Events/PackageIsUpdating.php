<?php

namespace Modules\Loyalty\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;
use Modules\Loyalty\Entities\Package;

class PackageIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
    private $package;

    public function __construct(Package $package, array $attributes)
    {
        $this->package = $package;
        parent::__construct($attributes);
    }

    public function getPackage()
    {
        return $this->package;
    }
}
