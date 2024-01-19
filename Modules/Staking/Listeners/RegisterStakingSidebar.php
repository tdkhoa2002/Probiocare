<?php

namespace Modules\Staking\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterStakingSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
        $menu->group(trans('core::sidebar.cryperr_manager'), function (Group $group) {
            $group->item(trans('staking::stakings.title.stakings'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('staking::packages.title.packages'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.staking.package.create');
                    $item->route('admin.staking.package.index');
                    $item->authorize(
                        $this->auth->hasAccess('staking.packages.index')
                    );
                });
                $item->item(trans('staking::orders.title.orders'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.staking.order.index');
                    $item->authorize(
                        $this->auth->hasAccess('staking.orders.index')
                    );
                });
// append





            });
        });

        return $menu;
    }
}
