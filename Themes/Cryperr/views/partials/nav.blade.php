@php
$logo = (setting('core::logo')) ? setting('core::logo') : Theme::url('images/logo.png');

$checkAuth = auth()->guard('customer')->check();
$balance_usd = 0;

if($checkAuth){
$customer = auth()->guard('customer')->user();
if($customer->wallets){
foreach ($customer->wallets as $wallet) {
$walletCurrency = $wallet->currency;
if($walletCurrency){
$balance_usd += $wallet->balance * $wallet->currency->usd_rate;
}
}
}
}
@endphp

<script>
    $(document).ready(function(){
    var total_balance = {{$balance_usd}};
    // alert(total_balance);
    $('.total_balance_usd').text(total_balance);
    })
</script>

<nav class="home-nav-bar navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="nav-body">
            <a class="navbar-brand" href="/products">
                <img src="{{ $logo }}" alt="" />
            </a>
            <div class="right-nav-mobile">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" href="#drawerMenu" role="button"
                    aria-controls="drawerMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                    @menu('main_menu', 'main_menu')
                </ul>

                <div class="right-nav">
                    @if (!$checkAuth)
                    <div class="d-flex">
                        <a class="btn btn-signin {{ Route::currentRouteName() !='fe.customer.customer.register' ?' btn-primary':"" }} me-2"
                            style="white-space: nowrap" href="{{route('fe.customer.customer.login')}}">{{ trans('home.sign_in') }}</a>
                        <a class="btn btn-signup {{ Route::currentRouteName() =='fe.customer.customer.register' ?' btn-primary':"" }} btn-text"
                            style="white-space: nowrap" href="{{route('fe.customer.customer.register')}}">{{ trans('home.sign_up') }}</a>
                    </div>
                    @else
                    <div class="d-flex align-items-center">
                        {{-- <div>
                            <button type="button" style="width:120px; height: 43px" class="btn btn-success">
                                $<span class="total_balance_usd" style="color: #fff;">
                                </span>
                                <img class="pointer" style="filter: brightness(0) invert(1);" width="20px"
                                    src="{{ Theme::url('images/icons/eye.png') }}" alt="">
                            </button>
                        </div> --}}
                        <div>
                            <a href="{{ route('fe.shoppingcart.getCart') }}" style="color: black">
                                <img class="pointer" src="{{ Theme::url('images/icons/icon-shop.png') }}" alt="">
                            </a>
                        </div>
                        <div class="ms-3">
                            <a href="{{route('fe.customer.customer.account')}}">
                                <div class="d-flex align-items-center">
                                    <span class="avatar-profile">{{ substr($customer->profile->firstname, 0, 1)
                                        }}</span>
                                    <span class="ms-2">{{$customer->profile->firstname}}
                                        {{$customer->profile->lastname}}</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Mobile drawer menu -->
            <div class="mobile-drawer-menu offcanvas offcanvas-start d-lg-none" tabindex="-1" id="drawerMenu"
                aria-labelledby="drawerMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="drawerMenuLabel">
                        <a class="navbar-brand" href="/">
                            <img src="{{ $logo }}" alt="" />
                        </a>
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav my-2 my-lg-0">
                        @menu('main_menu', 'main_menu')

                        {{-- <li class="nav-item"><a class="nav-link " aria-current="page"
                                href="{{route('fe.wallet.wallet.list')}}">Wallet</a></li>
                        <li class="nav-item"><a class="nav-link " aria-current="page"
                                href="{{route('fe.staking.staking.mystaking')}}">My Staking</a></li>
                        <li class="nav-item"><a class="nav-link " aria-current="page"
                                href="{{route('fe.customer.customer.account')}}">Account</a></li>
                        <li class="nav-item"><a class="nav-link " aria-current="page"
                                href="{{route('fe.customer.customer.setting')}}">Setting</a></li> --}}

                    </ul>
                </div>
                <div class="offcanvas-footer pb-2">
                    @if (!$checkAuth)
                    <a class="btn btn-primary btn-sign-with-email"
                        href="{{route('fe.customer.customer.register')}}">{{ trans('home.sign_up') }}</a>
                    <a class="btn btn-outline btn-sign-with-email" href="{{route('fe.customer.customer.login')}}">{{ trans('home.sign_in') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>