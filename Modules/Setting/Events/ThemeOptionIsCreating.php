<?php

namespace Modules\Setting\Events;

class ThemeOptionIsCreating
{
    private $themeOptionName;
    private $themeOptionValues;
    private $original;

    public function __construct($themeOptionName, $themeOptionValues)
    {
        $this->themeOptionName = $themeOptionName;
        $this->themeOptionValues = $themeOptionValues;
        $this->original = $themeOptionValues;
    }

    /**
     * @return mixed
     */
    public function getThemeOptionName()
    {
        return $this->themeOptionName;
    }

    /**
     * @return mixed
     */
    public function getThemeOptionValues()
    {
        return $this->themeOptionValues;
    }

    /**
     * @param mixed $themeOptionValues
     */
    public function setThemeOptionValues($themeOptionValues)
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
}
