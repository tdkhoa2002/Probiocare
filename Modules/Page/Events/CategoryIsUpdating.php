<?php

namespace Modules\Page\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;
use Modules\Page\Entities\Category;

class CategoryIsUpdating extends AbstractEntityHook implements EntityIsChanging
{
    private $category;

    public function __construct(Category $category, array $attributes)
    {
        $this->category = $category;
        parent::__construct($attributes);
    }

    /**
     * @return category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
