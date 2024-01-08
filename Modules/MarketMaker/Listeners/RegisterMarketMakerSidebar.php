<?php

namespace Modules\MarketMaker\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterMarketMakerSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('marketmaker::marketmaker.title.marketmakers'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                
                $item->item(trans('marketmaker::targetprices.title.targetprices'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.marketmaker.targetprice.create');
                    $item->route('admin.marketmaker.targetprice.index');
                    $item->authorize(
                        $this->auth->hasAccess('marketmaker.targetprices.index')
                    );
                });
                $item->item(trans('marketmaker::volumnizers.title.volumnizers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.marketmaker.volumnizer.create');
                    $item->route('admin.marketmaker.volumnizer.index');
                    $item->authorize(
                        $this->auth->hasAccess('marketmaker.volumnizers.index')
                    );
                });
// append


            });
        });
        return $menu;
    }
}
