<?php

namespace Modules\Core\Theme\Exceptions;

class ThemeJsonNotFoundException extends \Exception
{
	public function __construct($path)
    {
        $this->message = "theme.json file does not exist at [$path].";
    }
}
