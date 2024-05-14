@php
$lang = LaravelLocalization::setLocale() ? LaravelLocalization::setLocale() : 'vi';
$favicon = setting('core::favicon') ? setting('core::favicon') : Theme::url('favicon.ico');
$site_name = setting('core::site-name') ? setting('core::site-name') : 'Probiocare';
$site_description = setting('core::site-description') ? setting('core::site-description') : 'Probiocare';
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
    <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ url($alternateLocale . '/' . $alternateSlug) }}">
    @endforeach
    @endif
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="shortcut icon" href="{{ $favicon }}">
    <script>
        window.translations = {
            'auth' : @json(trans('auth')),
            'wallet' : @json(trans('wallet')),
        }
    </script>
    {{-- Font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;300;400;500;600;700&family=Montserrat:wght@100;300;400;500&display=swap"
        rel="stylesheet" />

    {{-- Jquery --}}
    <script src="/libs/jquery/jquery-3.7.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script> --}}

    {{-- Bootstrap --}}
    <link href="/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    {{-- Date --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="/libs/daterangepicker/daterangepicker.css" />

    {{-- select 2 --}}
    {{--
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> --}}
    {{-- Tradingview --}}
    <script type="text/javascript" src="/libs/tradingview/charting_library/charting_library.standalone.js"></script>
    <script type="text/javascript" src="/libs/tradingview/datafeeds/udf/dist/bundle.js"></script>

    <script src="https://d3js.org/d3.v4.min.js"></script>
    @include('partials.custom-style')

    {!! Theme::style('css/main.css') !!}

    @stack('css-stack')
    <script>
        const apiQuickBuy = "{{ route('fe.shoppingcart.quickBuy') }}";
        const apiAddToCart = "{{ route('fe.shoppingcart.addToCart') }}";
        const apiDeleteItem = "{{ route('fe.shoppingcart.deleteItem') }}";
        const apiLoadCart = "{{ route('fe.shoppingcart.loadCart') }}";
        const apiUpdateQty = "{{ route('fe.shoppingcart.updateQty') }}";
    </script>
</head>

<body>
    <main>
        @include('partials.nav')

        <div id="app">
            @yield('content')
        </div>
    </main>
    @include('partials.footer')
    <script src="https://code.jquery.com/jquery-3.0.0.min.js"
        integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0=" crossorigin="anonymous"></script>
    {!! Theme::script('js/lib.js') !!}
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

    {{-- All JS --}}
    {!! Theme::script('app/app.js') !!}
    {!! Theme::script('js/additional-methods.min.js') !!}
    {!! Theme::script('js/jquery.validate.js') !!}

    {!! Theme::script('js/script.js') !!}

    {{-- Others --}}
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}")
        @endif
        @if (session('errors'))
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif
        @if (session('warning'))
            toastr.warning("{{ session('warning') }}")
        @endif
    </script>
    
</body>

</html>