<?php

namespace Modules\Core\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterCoreSidebar extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->weight(1);
            $group->authorize(
                $this->auth->hasAccess('core.sidebar.group')
            );
        });
        $menu->group(trans('core::sidebar.system'), function (Group $group) {
            $group->weight(5);
        });
        $menu->group(trans('core::sidebar.cryperr_manager'), function (Group $group) {
            $group->weight(2);
        });
        $menu->group(trans('workshop::workshop.appearance'), function (Group $group) {
            $group->weight(4);
        });

        return $menu;
    }
}
