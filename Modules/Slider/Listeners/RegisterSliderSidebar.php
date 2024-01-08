<?php

namespace Modules\Slider\Listeners;

use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\Slider\Repositories\SliderRepository;
use Modules\User\Contracts\Authentication;

class RegisterSliderSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
        $menu->group(trans('workshop::workshop.appearance'), function (Group $group) {
            $group->item(trans('slider::sliders.title'), function (Item $item) {
                $item->weight(60);
                $item->icon('fa fa-sliders');
                $item->route('admin.slider.slider.index');
                $item->badge(function (Badge $badge, SliderRepository $sliderRepository) {
                    $badge->setClass('bg-green');
                    $badge->setValue($sliderRepository->countAll());
                });
                $item->authorize(
                    $this->auth->hasAccess('slider.sliders.index')
                );
            });
        });

        return $menu;
    }
}
