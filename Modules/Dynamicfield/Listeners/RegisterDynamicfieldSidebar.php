<?php

namespace Modules\Dynamicfield\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterDynamicfieldSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.system'), function (Group $group) {
            $group->item(trans('dynamicfield::dynamicfield.title.dynamicfield'), function (Item $item) {
                $item->icon('fa fa-cubes');
                $item->weight(50);
                $item->route('admin.dynamicfield.group.index');
                $item->authorize(
                    $this->auth->hasAccess('dynamicfield.dynamicfields.index')
                );
            });
        });

        return $menu;
    }
}
