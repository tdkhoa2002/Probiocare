<?php

namespace Modules\ShoppingCart\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterShoppingCartSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('shoppingcart::shoppingcarts.title.shoppingcarts'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('shoppingcart::orders.title.orders'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.shoppingcart.order.index');
                    $item->authorize(
                        $this->auth->hasAccess('shoppingcart.orders.index')
                    );
                });
            
// append


            });
        });

        return $menu;
    }
}
