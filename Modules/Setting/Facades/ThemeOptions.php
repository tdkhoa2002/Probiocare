<?php

namespace Modules\Setting\Facades;

use Illuminate\Support\Facades\Facade;

class ThemeOptions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'setting.themeOptions';
    }
}
