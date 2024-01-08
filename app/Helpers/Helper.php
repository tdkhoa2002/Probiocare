<?php

use Modules\Menu\Repositories\MenuItemRepository;


if (!function_exists('getMenu')) {
  function getMenu($id)
  {
    $menuItems = app(MenuItemRepository::class)->allRootsForMenu($id)->nest();

    return $menuItems;
  }
}
