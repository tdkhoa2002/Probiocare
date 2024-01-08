<?php

namespace Modules\Setting\Events;

use Modules\Setting\Entities\ThemeOption;

class ThemeOptionIsUpdating
{
    private $themeOptionName;
    private $themeOptionValues;
    private $original;
    /**
     * @var Setting
     */
    private $themeOption;

    public function __construct(ThemeOption $themeOption, $themeOptionName, $themeOptionValues)
    {
        $this->themeOptionName = $themeOptionName;
        $this->themeOptionValues = $themeOptionValues;
        $this->original = $themeOptionValues;
        $this->themeOption = $themeOption;
    }

    /**
     * @return mixed
     */
    public function getSettingName()
    {
        return $this->themeOptionName;
    }

    /**
     * @return mixed
     */
    public function getSettingValues()
    {
        return $this->themeOptionValues;
    }

    /**
     * @param mixed $themeOptionValues
     */
    public function setSettingValues($themeOptionValues)
    {
        $this->themeOptionValues = $themeOptionValues;
    }

    /**
     * @return mixed
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @return Setting
     */
    public function getSetting()
    {
        return $this->themeOption;
    }
}
