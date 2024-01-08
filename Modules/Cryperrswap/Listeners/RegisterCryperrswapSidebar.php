<?php

namespace Modules\Cryperrswap\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterCryperrswapSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('cryperrswap::cryperrswap.cryperrswap'), function (Item $item) {
                $item->icon('fa fa-file');
                $item->weight(3);
                $item->authorize(
                    $this->auth->hasAccess('cryperrswap.services.index')
                );

                $item->item(trans('cryperrswap::services.title.services'), function (Item $item) {
                    $item->icon('fa fa-file');
                    $item->weight(1);
                    $item->route('admin.cryperrswap.service.index');
                    $item->authorize(
                        $this->auth->hasAccess('cryperrswap.services.index')
                    );
                });
                $item->item(trans('cryperrswap::currencies.title.currencies'), function (Item $item) {
                    $item->icon('fa fa-file');
                    $item->weight(2);
                    $item->route('admin.cryperrswap.currency.index');
                    $item->authorize(
                        $this->auth->hasAccess('cryperrswap.currencies.index')
                    );
                });
            });
        });

        return $menu;
    }
}
