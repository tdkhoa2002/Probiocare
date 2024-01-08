<?php

namespace Modules\Setting\Blade;

use Illuminate\Support\Arr;

final class ThemeOptionDirective
{
    /**
     * @var string
     */
    private $themeOptionName;
    /**
     * @var string
     */
    private $locale;
    /**
     * @var string Default value
     */
    private $default;

    /**
     * @param $arguments
     */
    public function show($arguments)
    {
        $this->extractArguments($arguments);

        return e(themeOption($this->themeOptionName, $this->locale, $this->default));
    }

    /**
     * @param array $arguments
     */
    private function extractArguments(array $arguments)
    {
        $this->themeOptionName = Arr::get($arguments, 0);
        $this->locale = Arr::get($arguments, 1);
        $this->default = Arr::get($arguments, 2);
    }
}
