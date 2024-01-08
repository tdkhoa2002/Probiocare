<?php

namespace Modules\Setting\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ThemeOptionRepository extends BaseRepository
{
    public function createOrUpdate($settings);
    public function findByName($themeOptionName);
    public function findByTheme($theme);
    public function get($settingName);
    public function getAllConfigThemeOptions();
    public function savedThemeOptions($theme);
}
