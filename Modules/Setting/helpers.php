<?php

if (!function_exists('setting')) {
    function setting($name, $locale = null, $default = null)
    {
        return app('setting.settings')->get($name, $locale, $default);
    }
}

if (!function_exists('themeOption')) {
    function themeOption($name, $locale = null, $default = null)
    {
        return app('setting.themeOptions')->get($name, $locale, $default);
    }
}
