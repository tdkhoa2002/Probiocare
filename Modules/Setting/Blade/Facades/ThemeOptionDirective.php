<?php

namespace Modules\Setting\Blade\Facades;

use Illuminate\Support\Facades\Facade;

final class ThemeOptionDirective extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'themeOption.themeOption.directive';
    }
}
