<?php

namespace Modules\Setting\Support;

use Modules\Setting\Contracts\ThemeOption;
use Modules\Setting\Repositories\ThemeOptionRepository;

class ThemeOptions implements ThemeOption
{
    /**
     * @var ThemeOptionRepository
     */
    private $themeOption;

    /**
     * @param ThemeOptionRepository $themeOption
     */
    public function __construct(ThemeOptionRepository $themeOption)
    {
        $this->themeOption = $themeOption;
    }

    /**
     * Getting the ThemeOption
     * @param  string $name
     * @param  string   $locale
     * @param  string   $default
     * @return mixed
     */
    public function get($name, $locale = null, $default = null)
    {
        $defaultFromConfig = $this->getDefaultFromConfigFor($name);

        $themeOption = $this->themeOption->findByName($name);
        if ($themeOption === null) {
            return is_null($default) ? $defaultFromConfig : $default;
        }

        if ($themeOption->isMedia() && $media = $themeOption->files()->first()) {
            return $media->path;
        }

        if ($themeOption->isTranslatable) {
            if ($themeOption->hasTranslation($locale)) {
                return trim($themeOption->translate($locale)->value) === '' ? $defaultFromConfig : $themeOption->translate($locale)->value;
            }
        } else {
            return trim($themeOption->plainValue) === '' ? $defaultFromConfig : $themeOption->plainValue;
        }

        return $defaultFromConfig;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $name
     * @return bool
     */
    public function has($name)
    {
        $default = microtime(true);

        return $this->get($name, null, $default) !== $default;
    }

    /**
     * Set a given configuration value.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return \Modules\ThemeOption\Entities\ThemeOption
     */
    public function set($key, $value)
    {
        return $this->themeOption->create([
            'name' => $key,
            'plainValue' => $value,
        ]);
    }

    /**
     * Get the default value from the ThemeOptions configuration file,
     * for the given ThemeOption name.
     * @param string $name
     * @return string
     */
    private function getDefaultFromConfigFor($name)
    {
        list($module, $themeOptionName) = explode('::', $name);
        return setting("core::".$themeOptionName);
    }
}
