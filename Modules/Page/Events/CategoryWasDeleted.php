<?php

namespace Modules\Page\Events;

use Modules\Page\Entities\Category;

class CategoryWasDeleted
{
    /**
     * @var category
     */
    public $category;

    public function __construct($category)
    {
        $this->category = $category;
    }
}
