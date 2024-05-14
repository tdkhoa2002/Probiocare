<?php

namespace Modules\Loyalty\Events;

use Modules\Loyalty\Entities\Package;

class PackageWasDeleted
{
    public $package;

    public function __construct($package)
    {
        $this->package = $package;
    }
}
