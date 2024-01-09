@php
    $lang = LaravelLocalization::setLocale() ? LaravelLocalization::setLocale() : 'en';
    $favicon = setting('core::site-logo') ? setting('core::site-logo') : Theme::url('favicon.ico');
    $site_name = setting('core::site-name') ? setting('core::site-name') : 'Cryperr Trading';
    $site_description = setting('core::site-description') ? setting('core::site-description') : 'Cryperr Trading';
@endphp

<!DOCTYPE html>
<html>

<head lang="{{ $lang }}">
    <meta charset="UTF-8">
    @section('meta')
        <meta name="description" content="{{ $site_description }}" />
    @show
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="pusher-key" content={{ config('broadcasting.connections.pusher.key') }}>
    <meta name="cluster" content={{ config('broadcasting.connections.pusher.options.cluster') }}>
    <meta name="app-url" content={{ config('app.url') }}>

    <title>
        @section('title') {{ $site_name }} @show
    </title>
    @if (isset($alternate))
        @foreach ($alternate as $alternateLocale => $alternateSlug)
            <link rel="alternate" hreflang="{{ $alternateLocale }}"
                href="{{ url($alternateLocale . '/' . $alternateSlug) }}">
        @endforeach
    @endif
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="shortcut icon" href="{{ $favicon }}">

    {{-- Font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;400;500;700&family=Montserrat:wght@100;300;400;500&display=swap"
        rel="stylesheet" />

    {{-- Jquery --}}
    <script src="/libs/jquery/jquery-3.7.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> --}}

    {{-- Bootstrap --}}
    <link href="/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    {{-- Date --}}
    <link rel="stylesheet" type="text/css" href="/libs/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    {{-- select 2 --}}
    {{-- <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> --}}

    {{-- QR code --}}
    <script src="/libs/qrcodejs/qrcode.min.js"></script>
    @include('partials.custom-style')

    {{-- Other --}}
    {!! Theme::style('css/main.css') !!}

    @stack('css-stack')
</head>

<body>
    @include('partials.nav')

    <div class="private-layout">
        <div class="private-layout-body p-15 p-lg-0">
            @include('partials.menu-panel')
            <div class="app-content" id="app">
                @yield('content')
            </div>
        </div>
    </div>

    @if (auth()->guard('customer')->check())
        @include('partials.navigator')
    @endif

    @include('partials.footer')

    {!! Theme::script('app/app.js') !!}
    {!! Theme::script('js/lib.js') !!}
    

    @yield('scripts')

    <?php if (Setting::has('core::analytics-script')): ?>
    {!! Setting::get('core::analytics-script') !!}
    <?php endif; ?>

    @stack('js-stack')

    {{-- Toast --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Bootstrap --}}
    <script src="/libs/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    {{-- Date --}}
    <script type="text/javascript" src="/libs/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/libs/daterangepicker/daterangepicker.js"></script>
    {!! Theme::script('js/script.js') !!}
    {{-- Others --}}
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}")
        @endif
        @if (session('warning'))
            toastr.warning("{{ session('warning') }}")
        @endif
    </script>
</body>

</html>
