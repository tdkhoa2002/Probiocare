<?php

namespace Modules\Dynamicfield\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Dynamicfield\Listeners\AddNewProcess;
use Modules\Dynamicfield\Listeners\UpdateProcess;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        UpdateProcess::class
    ];
    protected $listen = [
       
    ];
}
