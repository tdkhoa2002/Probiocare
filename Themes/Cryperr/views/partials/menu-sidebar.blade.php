<ul class="docs-navbar-left-menu">
    @foreach ($menus as $item)
        @php
            $childMenu = $item->children()->get();
            $posts = getPageByCategory($item->id);
            $checkUrl = $page->slug;
        @endphp
        @if (count($childMenu) > 0)
            <div class="docs-menu-has-child">
                <p class="docs-menu-toggle-dropdown">
                    <span>{{ $item->title }}</span> <i class="fa fa-angle-down"></i>
                </p>

                <div class="docs-list-post">
                    @if (isset($posts) && count($posts) > 0)
                        <ul>
                            @foreach ($posts as $item)
                                <li>
                                    <a href="{{ route('page', [$item->slug]) }}"
                                        class="docs-menu-item {{ $item->slug == $checkUrl ? 'docs-active' : '' }}">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @include('partials.menu-sidebar', ['menus' => $childMenu])
                </div>

            </div>
        @else
            <div class="docs-menu-has-child">
                <p class="docs-menu-toggle-dropdown">
                    <span>{{ $item->title }}</span>
                    @if (count($posts) > 0)
                        <i class="fa fa-angle-down"></i>
                    @endif
                </p>

                @if (isset($posts) && count($posts) > 0)
                    <div class="docs-list-post">
                        <ul>
                            @foreach ($posts as $item)
                                <li>
                                    <a href="{{ route('page', [$item->slug]) }}"
                                        class="docs-menu-item {{ $item->slug == $checkUrl ? 'docs-active' : '' }}">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</ul>
