<?php

namespace Modules\Workshop\Http\Controllers\Api;

use Modules\Core\Theme\Theme;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;

class ThemeController extends Controller
{
    public function publishAssets(Theme $theme)
    {
        try {
            Artisan::call('stylist:publish', ['theme' => $theme->getName()]);
        } catch (InvalidArgumentException $e) {
        }
    }
}
