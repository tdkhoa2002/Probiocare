<div class="tabs-header">
    <div class="container-fluid">
        <ul class="tab-main-list nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Route::currentRouteName() =='fe.p2p.market.agents' ?'active':"" }}"  href="{{ route('fe.p2p.market.agents') }}">
                    <img class="me-2" width="24px" height="24px"
                        src="{{ Theme::url('images/icons/p2p.png') }}" alt="">
                    P2P
                </a>
            </li>
            @if($authCheck)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Route::currentRouteName() =='fe.p2p.market.orders' ?'active':"" }}" href="{{ route('fe.p2p.market.orders') }}">
                    <img class="me-2" width="24px" height="24px"
                        src="{{ Theme::url('images/icons/battery.png') }}" alt="">
                    Orders
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ Route::currentRouteName() =='fe.p2p.market.center' ?'active':"" }}" href="{{ route('fe.p2p.market.center') }}">
                    <img class="me-2" width="24px" height="24px"
                        src="{{ Theme::url('images/icons/user-outline.png') }}" alt="">
                    P2P Center
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>