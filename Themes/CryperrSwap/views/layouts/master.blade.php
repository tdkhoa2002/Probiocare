@php
    $lang = LaravelLocalization::setLocale() ? LaravelLocalization::setLocale() : 'en';
    $favicon = setting('core::favicon') ? setting('core::favicon') : Theme::url('favicon.ico');
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

    

    {{-- Jquery --}}
    <script src="/libs/jquery/jquery-3.7.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> --}}

    {{-- Bootstrap --}}
    <link href="/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    {{-- Date --}}
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="/libs/daterangepicker/daterangepicker.css" />

    {{-- select 2 --}}
    {{-- <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> --}}

    {{-- QR code --}}
    <script src="/libs/qrcodejs/qrcode.min.js"></script>

    {{-- Tradingview --}}
    <script type="text/javascript" src="/libs/tradingview/charting_library/charting_library.standalone.js"></script>
    <script type="text/javascript" src="/libs/tradingview/datafeeds/udf/dist/bundle.js"></script>

    {{-- Other --}}
    {!! Theme::style('css/main.css') !!}

    @stack('css-stack')

    @include('partials.custom-style')
</head>

<body>

    {{-- @auth
    @include('partials.admin-bar')
    @endauth --}}

    @include('partials.nav')

    <div id="app">
        @yield('content')
    </div>
    @include('partials.footer')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"
        integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    {!! Theme::script('js/all.js') !!}
    @yield('scripts')

    <?php if (Setting::has('core::analytics-script')): ?>
    {!! Setting::get('core::analytics-script') !!}
    <?php endif; ?>

    @stack('js')

    {{-- Toast --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Bootstrap --}}
    <script src="/libs/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    {{-- Date --}}
    <script type="text/javascript" src="/libs/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/libs/daterangepicker/daterangepicker.js"></script>

    {{-- Others --}}
    {!! Theme::script('app/app.js') !!}
    {!! Theme::script('js/all.js') !!}

    {{-- Others --}}
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif
        @if (session('success'))
            toastr.success("{{ session('success') }}")
        @endif
        @if (session('warning'))
            toastr.warning("{{ session('warning') }}")
        @endif
    </script>

</body>

</html>
