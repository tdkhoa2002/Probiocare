<?php

namespace Modules\Setting\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Setting\Events\Handlers\ClearSettingsCache;
use Modules\Setting\Events\Handlers\ClearThemeOptionsCache;
use Modules\Setting\Events\SettingWasCreated;
use Modules\Setting\Events\SettingWasUpdated;
use Modules\Setting\Events\ThemeOptionWasCreated;
use Modules\Setting\Events\ThemeOptionWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SettingWasCreated::class => [
            ClearSettingsCache::class,
        ],
        SettingWasUpdated::class => [
            ClearSettingsCache::class,
        ],
        ThemeOptionWasCreated::class => [
            ClearThemeOptionsCache::class,
        ],
        ThemeOptionWasUpdated::class => [
            ClearThemeOptionsCache::class,
        ],
    ];
}
