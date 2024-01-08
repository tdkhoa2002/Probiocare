<div class="docs-header">
    <div class="container">
        <div class="docs-header-content">
            <div class="docs-logo">
                <a href="{{ route('homepage') }}">
                    <img class="navbar__logo" src="@setting('core::logo')" alt="@setting('core::site-name')">
                </a>
            </div>
            <div class="docs-menu-header">
                <ul>
                    @menu("main_menu","main_menu")
                </ul>
            </div>
            <div class="docs-menu-header-dark"></div>
        </div>
    </div>
</div>

<div class="docs-header-clone">
</div>
