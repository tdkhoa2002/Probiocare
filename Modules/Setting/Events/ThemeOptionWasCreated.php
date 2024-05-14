<?php

namespace Modules\Setting\Events;

use Modules\Media\Contracts\StoringMedia;
use Modules\Setting\Entities\ThemeOption;

class ThemeOptionWasCreated implements StoringMedia
{
    /**
     * @var ThemeOption
     */
    public $themeOption;

    /**
     * @var array
     */
    public $data;

    public function __construct(ThemeOption $themeOption, $data)
    {
        $this->themeOption = $themeOption;
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function getEntity()
    {
        return $this->themeOption;
    }

    /**
     * @inheritDoc
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
