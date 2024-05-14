<div class="wrap-panel">
    <div class="panel">
        <div class="menu-list">
            <a class="menu-item {{ Route::currentRouteName() =='fe.wallet.wallet.list' ?'active':"" }}" href="{{route('fe.wallet.wallet.list')}}">
                <img src="{{ Theme::url('images/menu/wallet.png') }}" alt="" />
                <div class="name"> Wallet </div>
            </a>
            {{-- <a class="menu-item {{ Route::currentRouteName() =='fe.wallet.wallet.convert' ?'active':"" }}" href="{{route('fe.wallet.wallet.convert')}}">
                <img src="{{ Theme::url('images/menu/prostore.png') }}" alt="" />
                <div class="name"> {{__('menu.convert')}} </div>
            </a> --}}
            <a class="menu-item {{ Route::currentRouteName() =='fe.product.product.list' ?'active':"" }}" href="{{route('fe.product.product.list')}}">
                <img src="{{ Theme::url('images/menu/wallet.png') }}" alt="" />
                <div class="name"> Products </div>
            </a>
            <a class="menu-item 
            {{ Route::currentRouteName() == 'fe.loyalty.loyalty.list-packages' ? 'active' : '' }}
            {{ Route::currentRouteName() == 'fe.loyalty.loyalty.myhistory' ? 'active' : '' }}
            {{ Route::currentRouteName() == 'fe.loyalty.loyalty.mystaking' ? 'active' : '' }}
            " href="{{ route('fe.loyalty.loyalty.list-packages') }}">
                <img src="{{ Theme::url('images/menu/convert.png') }}" alt="" />
                <div class="name"> Loyalty </div>
                <img class="arrow-bottom" src="{{ Theme::url('images/arrow-bottom.png') }}" alt="" />
            </a>
            <ul class="submenu">
                <li class="{{ Route::currentRouteName() == 'fe.loyalty.loyalty.list-packages' ? 'active' : '' }}">
                    <a href="{{ route('fe.loyalty.loyalty.list-packages') }}"> Loyalty Package </a>
                </li> 
                <li class="{{ Route::currentRouteName() == 'fe.loyalty.loyalty.mystaking' ? 'active' : '' }}">
                    <a href="{{ route('fe.loyalty.loyalty.mystaking') }}"> My Package </a>
                </li>
                <li class="{{ Route::currentRouteName() == 'fe.loyalty.loyalty.myhistory' ? 'active' : '' }}">
                    <a href="{{ route('fe.loyalty.loyalty.myhistory') }}"> History </a>
                </li> 
            </ul>
            <a class="menu-item {{ Route::currentRouteName() =='fe.customer.customer.affiliate' ?'active':"" }}" href="{{route('fe.customer.customer.affiliate')}}">
                <img src="{{ Theme::url('images/navigator/icon-affiliate.png') }}" alt="" />
                <div class="name"> Affiliate </div>
            </a>
            <a class="menu-item {{ Route::currentRouteName() =='fe.customer.customer.account' ?'active':"" }}" href="{{route('fe.customer.customer.account')}}">
                <img src="{{ Theme::url('images/menu/account.png') }}" alt="" />
                <div class="name"> Account </div>
            </a>
            <a class="menu-item {{ Route::currentRouteName() =='fe.customer.customer.setting' ?'active':"" }}" href="{{route('fe.customer.customer.setting')}}">
                <img src="{{ Theme::url('images/menu/setting.png') }}" alt="" />
                <div class="name"> Setting </div>
            </a>
        </div>
    </div>
</div>
