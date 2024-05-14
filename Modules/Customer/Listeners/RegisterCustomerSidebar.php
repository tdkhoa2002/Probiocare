<?php

namespace Modules\Customer\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterCustomerSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('customer::customers.title.customers'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */);
                $item->item(trans('customer::customers.title.customers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.customer.customer.create');
                    $item->route('admin.customer.customer.index');
                    $item->authorize(
                        $this->auth->hasAccess('customer.customers.index')
                    );
                });
                $item->item(trans('customer::paymentmethods.title.paymentmethods'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.customer.paymentmethod.create');
                    $item->route('admin.customer.paymentmethod.index');
                    $item->authorize(
                        $this->auth->hasAccess('customer.paymentmethods.index')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
