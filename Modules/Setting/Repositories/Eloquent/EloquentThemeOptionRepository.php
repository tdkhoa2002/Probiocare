<?php

namespace Modules\Setting\Repositories\Eloquent;

use Modules\Setting\Repositories\ThemeOptionRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Setting\Events\ThemeOptionIsCreating;
use Modules\Setting\Events\ThemeOptionIsUpdating;
use Modules\Setting\Events\ThemeOptionWasCreated;
use Modules\Setting\Events\ThemeOptionWasUpdated;

class EloquentThemeOptionRepository extends EloquentBaseRepository implements ThemeOptionRepository
{


    /**
     * Create or update the settings
     * @param $settings
     * @return mixed|void
     */
    public function createOrUpdate($settings)
    {
        $this->removeTokenKey($settings);

        foreach ($settings as $settingName => $settingValues) {
            if ($settingName == 'medias_single') {
                foreach ($settingValues as $key => $value) {
                    $normalisedValue = [$settingName => [$key => $value]];
                    if ($setting = $this->findByName($key)) {
                        $this->updateThemeOption($setting, $normalisedValue);
                    } else {
                        $this->createForName($key, $normalisedValue);
                    }
                }
            } else {
                if ($setting = $this->findByName($settingName)) {
                    $this->updateThemeOption($setting, $settingValues);
                } else {
                    $this->createForName($settingName, $settingValues);
                }
            }
        }
    }

    /**
     * Remove the token from the input array
     * @param $settings
     */
    private function removeTokenKey(&$settings)
    {
        unset($settings['_token']);
    }

    /**
     * Find a setting by its name
     * @param $settingName
     * @return mixed
     */
    public function findByName($settingName)
    {
        return $this->model->where('name', $settingName)->first();
    }

    /**
     * Create a setting with the given name
     * @param string $settingName
     * @param $settingValues
     * @return Setting
     */
    private function createForName($themeOptionName, $themeOptionValues)
    {
        event($event = new ThemeOptionIsCreating($themeOptionName, $themeOptionValues));
        $theme =  setting('core::template', null, 'Cryperr');

        $themeOption = new $this->model();
        $themeOption->name = $themeOptionName;
        $themeOption->theme = $theme;
        if ($this->isTranslatableThemeOption($themeOptionName)) {
            $themeOption->isTranslatable = true;
            $this->setTranslatedAttributes($event->getThemeOptionValues(), $themeOption);
        } else {
            $themeOption->isTranslatable = false;
            $themeOption->plainValue = $this->getThemeOptionPlainValue($event->getThemeOptionValues());
        }

        $themeOption->save();

        event(new ThemeOptionWasCreated($themeOption, $themeOptionValues));

        return $themeOption;
    }
    private function updateThemeOption($themeOption, $themeOptionValues)
    {
        $name = $themeOption->name;
        event($event = new ThemeOptionIsUpdating($themeOption, $name, $themeOptionValues));

        if ($this->isTranslatableThemeOption($name)) {
            $this->setTranslatedAttributes($event->getSettingValues(), $themeOption);
        } else {
            $themeOption->plainValue = $this->getThemeOptionPlainValue($event->getSettingValues());
        }
        $themeOption->save();

        event(new ThemeOptionWasUpdated($themeOption, $themeOptionValues));

        return $themeOption;
    }

    /**
     * @param $settingValues
     * @param $setting
     */
    private function setTranslatedAttributes($themeOptionValues, $themeOption)
    {
        foreach ($themeOptionValues as $lang => $value) {
            $themeOption->translateOrNew($lang)->value = $value;
        }
    }

    private function isTranslatableThemeOption($themeOptionName)
    {
        $allConfigThemeOptions = $this->getAllConfigThemeOptions();

        list($theme, $themeOption) = explode('::', $themeOptionName);
        $isTranslate = false;
        foreach ($allConfigThemeOptions as $themeOptions) {
            if (isset($themeOptions['translatable']) && isset($themeOptions['translatable'][$themeOption])) {
                $isTranslate = true;
                break;
            }
        }
        return $isTranslate;
    }

    /**
     * Find settings by module name
     * @param  string $module Module name
     * @return mixed
     */
    public function findByTheme($theme)
    {
        return $this->model->where('theme', $theme)->get();
    }

    /**
     * Find the given setting name for the given module
     * @param  string $settingName
     * @return mixed
     */
    public function get($settingName)
    {
        return $this->model->where('name', 'LIKE', "{$settingName}")->first();
    }


    /**
     * Return the setting value(s). If values are ann array, json_encode them
     * @param string|array $settingValues
     * @return string
     */
    private function getThemeOptionPlainValue($themeOptionValues)
    {
        if (is_array($themeOptionValues)) {
            return json_encode($themeOptionValues);
        }

        return $themeOptionValues;
    }

    public function getAllConfigThemeOptions()
    {
        $theme =  setting('core::template', null, 'Cryperr');
        $pathField = base_path('Themes/' . $theme . '/ThemeOptions/field.php');
        $defaultThemeOptions =  config('asgard.setting.themeOptions');
        $themeOptions = [];

        if (file_exists($pathField)) {
            $themeOptions = require($pathField);
        }
        if (is_array($themeOptions) && count($themeOptions) > 0) {
            foreach ($themeOptions as $key => $themeoption) {
                if (isset($defaultThemeOptions[$key])) {
                    if (isset($defaultThemeOptions[$key]['translatable'])) {
                        $defaultThemeOptions[$key]['translatable'] = array_merge($defaultThemeOptions[$key]['translatable'], $themeoption['translatable']);
                    } else {
                        $defaultThemeOptions[$key]['translatable'] = $themeoption['translatable'];
                    }

                    if (isset($defaultThemeOptions[$key]['non-translatable'])) {
                        $defaultThemeOptions[$key]['non-translatable'] = array_merge($defaultThemeOptions[$key]['non-translatable'], $themeoption['non-translatable']);
                    } else {
                        $defaultThemeOptions[$key]['non-translatable'] = $themeoption['non-translatable'];
                    }
                } else {
                    $defaultThemeOptions[$key] = $themeoption;
                }
            }
        }
        return $defaultThemeOptions;
    }

    public function savedThemeOptions($theme)
    {
        $themeOptions = [];
        foreach ($this->findByTheme($theme) as $themeOption) {
            $themeOptions[$themeOption->name] = $themeOption;
        }
        return $themeOptions;
    }
}
