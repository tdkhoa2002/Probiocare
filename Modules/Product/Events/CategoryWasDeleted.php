<?php

namespace Modules\Product\Events;

use Modules\Product\Entities\Category;

class CategoryWasDeleted
{
    /**
     * @var Category
     */
    public $Category;

    public function __construct($Category)
    {
        $this->Category = $Category;
    }
}
