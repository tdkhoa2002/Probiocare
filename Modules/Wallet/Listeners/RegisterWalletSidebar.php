<?php

namespace Modules\Wallet\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterWalletSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('wallet::wallets.title.wallets'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */);
                $item->item(trans('wallet::blockchains.title.blockchains'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.wallet.blockchain.create');
                    $item->route('admin.wallet.blockchain.index');
                    $item->authorize(
                        $this->auth->hasAccess('wallet.blockchains.index')
                    );
                });
                $item->item(trans('wallet::currencies.title.currencies'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.wallet.currency.create');
                    $item->route('admin.wallet.currency.index');
                    $item->authorize(
                        $this->auth->hasAccess('wallet.currencies.index')
                    );
                });
                $item->item(trans('wallet::transactions.title.transactions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.wallet.transaction.index');
                    $item->authorize(
                        $this->auth->hasAccess('wallet.transactions.index')
                    );
                });
                $item->item(trans('wallet::wallets.title.wallets'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.wallet.wallet.index');
                    $item->authorize(
                        $this->auth->hasAccess('wallet.wallets.index')
                    );
                });
                $item->item(trans('wallet::chainwallets.title.chainwallets'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.wallet.chainwallet.create');
                    $item->route('admin.wallet.chainwallet.index');
                    $item->authorize(
                        $this->auth->hasAccess('wallet.chainwallets.index')
                    );
                });
                $item->item(trans('wallet::crawlhistories.title.crawlhistories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.wallet.crawlhistory.index');
                    $item->authorize(
                        $this->auth->hasAccess('wallet.crawlhistories.index')
                    );
                });
                // append


            });
        });

        return $menu;
    }
}
