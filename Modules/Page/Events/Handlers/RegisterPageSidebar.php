<?php

namespace Modules\Page\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterPageSidebar extends AbstractAdminSidebar
{
    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('page::pages.pages'), function (Item $item) {
                $item->icon('fa fa-file');
                $item->weight(1);
                $item->route('admin.page.page.index');
                $item->authorize(
                    $this->auth->hasAccess('page.pages.index')
                );

                $item->item(trans('page::pages.pages'), function (Item $item) {
                    $item->icon('fa fa-file');
                    $item->weight(1);
                    $item->route('admin.page.page.index');
                    $item->authorize(
                        $this->auth->hasAccess('page.pages.index')
                    );
                });
            });

            $group->item(trans('page::posts.posts'), function (Item $item) {
                $item->icon('fa fa-file');
                $item->weight(2);
                $item->route('admin.post.post.index');
                $item->authorize(
                    $this->auth->hasAccess('post.posts.index') or $this->auth->hasAccess('category.categories.index')
                );

                $item->item(trans('page::posts.posts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(1);
                    $item->append('admin.post.post.create');
                    $item->route('admin.post.post.index');
                    $item->authorize(
                        $this->auth->hasAccess('post.posts.index')
                    );
                });

                $item->item(trans('page::categories.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(2);
                    $item->append('admin.category.category.create');
                    $item->route('admin.category.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('category.categories.index')
                    );
                });
            });
        });

        return $menu;
    }
}
