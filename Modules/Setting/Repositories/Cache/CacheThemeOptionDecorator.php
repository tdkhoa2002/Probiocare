<?php

namespace Modules\Setting\Repositories\Cache;

use Modules\Setting\Repositories\ThemeOptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheThemeOptionDecorator extends BaseCacheDecorator implements ThemeOptionRepository
{
    public function __construct(ThemeOptionRepository $themeoption)
    {
        parent::__construct();
        $this->entityName = 'setting.themeoptions';
        $this->repository = $themeoption;
    }

    /**
     * Create or update the settings
     * @param $settings
     * @return mixed
     */
    public function createOrUpdate($themeOptions)
    {
        $this->cache->tags($this->entityName)->flush();

        return $this->repository->createOrUpdate($themeOptions);
    }

    /**
     * Find a setting by its name
     * @param $settingName
     * @return mixed
     */
    public function findByName($themeOptionName)
    {
        return $this->remember(function () use ($themeOptionName) {
            return $this->repository->findByName($themeOptionName);
        });
    }



    /**
     * Return the saved module settings
     * @param $module
     * @return mixed
     */
    public function savedThemeOptions($theme)
    {
        return $this->remember(function () use ($theme) {
            return $this->repository->savedThemeOptions($theme);
        });
    }

    /**
     * Find settings by module name
     * @param  string $module
     * @return mixed
     */
    public function findByTheme($theme)
    {
        return $this->remember(function () use ($theme) {
            return $this->repository->findByTheme($theme);
        });
    }

    /**
     * Find the given setting name for the given module
     * @param  string $settingName
     * @return mixed
     */
    public function get($settingName)
    {
        return $this->remember(function () use ($settingName) {
            return $this->repository->get($settingName);
        });
    }

    public function getAllConfigThemeOptions()
    {
        return $this->remember(function () {
            return $this->repository->getAllConfigThemeOptions();
        });
    }
}
