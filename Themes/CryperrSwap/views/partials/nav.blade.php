@php
$logo = (setting('core::logo')) ? setting('core::logo') : Theme::url('images/logo.png');

@endphp

<nav class="home-nav-bar navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="nav-body">
            <a class="navbar-brand" href="/">
                <img src="{{ $logo }}" alt="" />
            </a>
            <div class="right-nav-mobile">
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" href="#drawerMenu" role="button" aria-controls="drawerMenu">
                    <svg viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.599976 2.00005C0.599976 1.68179 0.726404 1.37656 0.951447 1.15152C1.17649 0.926477 1.48172 0.800049 1.79998 0.800049H16.2C16.5182 0.800049 16.8235 0.926477 17.0485 1.15152C17.2735 1.37656 17.4 1.68179 17.4 2.00005C17.4 2.31831 17.2735 2.62353 17.0485 2.84858C16.8235 3.07362 16.5182 3.20005 16.2 3.20005H1.79998C1.48172 3.20005 1.17649 3.07362 0.951447 2.84858C0.726404 2.62353 0.599976 2.31831 0.599976 2.00005ZM0.599976 8.00005C0.599976 7.68179 0.726404 7.37656 0.951447 7.15152C1.17649 6.92648 1.48172 6.80005 1.79998 6.80005H16.2C16.5182 6.80005 16.8235 6.92648 17.0485 7.15152C17.2735 7.37656 17.4 7.68179 17.4 8.00005C17.4 8.31831 17.2735 8.62353 17.0485 8.84858C16.8235 9.07362 16.5182 9.20005 16.2 9.20005H1.79998C1.48172 9.20005 1.17649 9.07362 0.951447 8.84858C0.726404 8.62353 0.599976 8.31831 0.599976 8.00005ZM0.599976 14C0.599976 13.6818 0.726404 13.3766 0.951447 13.1515C1.17649 12.9265 1.48172 12.8 1.79998 12.8H16.2C16.5182 12.8 16.8235 12.9265 17.0485 13.1515C17.2735 13.3766 17.4 13.6818 17.4 14C17.4 14.3183 17.2735 14.6235 17.0485 14.8486C16.8235 15.0736 16.5182 15.2 16.2 15.2H1.79998C1.48172 15.2 1.17649 15.0736 0.951447 14.8486C0.726404 14.6235 0.599976 14.3183 0.599976 14Z" fill="#FF7426"/>
                    </svg>
                </button>
            </div>

            <!-- Desktop menu -->
            <div class="collapse navbar-collapse justify-content-between">
                <ul class="navbar-nav my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px">
                    @menu('main_menu', 'main_menu')
                </ul>

                <div class="right-nav">
                    <div class="d-flex">
                        <a class="btn btn-signin btn-primary me-2" style="white-space: nowrap"
                            href="{{url('/')}}">Swap Now!</a>
                    </div>
                </div>
            </div>

            <!-- Mobile drawer menu -->
            <div class="mobile-drawer-menu offcanvas offcanvas-start d-lg-none" tabindex="-1" id="drawerMenu"
                aria-labelledby="drawerMenuLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="drawerMenuLabel">
                        <a class="navbar-brand" href="/">
                            <img src="{{$logo}}" alt="" />
                        </a>
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav my-2 my-lg-0">
                        @menu('main_menu', 'main_menu')
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>