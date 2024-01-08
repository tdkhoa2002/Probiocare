<?php

namespace Modules\Core\Theme\Exceptions;

class ThemeNotFoundException extends \Exception
{
	public function __construct($themeName)
    {
        $this->message = "Theme [$themeName] is not found. Contact admin for more detail! Readmore at docs.cryperr.com/theme";
    }
}