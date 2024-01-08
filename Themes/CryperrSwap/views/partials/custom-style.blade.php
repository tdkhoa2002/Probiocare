@php
$primary_color = ( themeOption(setting('core::template', null, '').'::theme_primary_color') != "" ) ? $site_color =
themeOption(setting('core::template', null, '').'::theme_primary_color') :"#FF7426";

$font_family = ( themeOption(setting('core::template', null, '').'::theme_font_family') != "" ) ? $site_color =
themeOption(setting('core::template', null, '').'::theme_font_family') :"Kanit";
@endphp
{{-- Font --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
href="https://fonts.googleapis.com/css2?family={{$font_family}}:wght@200;300;400;500;600;700"
rel="stylesheet" />

<style>
    :root {
        --primary_background_color: {{$primary_color}};

        --primary_text_color: {{$primary_color}};

        --primary_border_color: {{$primary_color}};
    }

    * {
        font-family: "{{$font_family}}", sans-serif;
    }

    .swap-li a.active,
    .swap-li:hover,
    .swap-btn input,
    .btn-primary {
        background-color: var(--primary_background_color);
    }

    .swap-box,
    .btn-primary,
    .modal .modal-content {
        border: 1px var(--primary_border_color) solid;
    }

    .home-nav-bar.navbar-expand-lg .navbar-toggler svg path {
        fill: var(--primary_background_color);
    }

    .text-primary,
    .status-alert b,
    .home-nav-bar.navbar-expand-lg .navbar-nav .nav-item .nav-link.active {
        color: var(--primary_text_color) !important;
    }
</style>