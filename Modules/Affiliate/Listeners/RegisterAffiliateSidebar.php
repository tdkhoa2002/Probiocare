<?php

namespace Modules\Affiliate\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterAffiliateSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('affiliate::affiliates.title.affiliates'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(110);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('affiliate::affiliates.title.affiliates'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.affiliate.affiliate.create');
                    $item->route('admin.affiliate.affiliate.index');
                    $item->authorize(
                        $this->auth->hasAccess('affiliate.affiliates.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
