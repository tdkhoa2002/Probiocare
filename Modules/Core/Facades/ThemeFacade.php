<?php
namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ThemeFacade extends Facade
{
	public static function getFacadeAccessor()
    {
        return 'stylist.theme';
    }
}
