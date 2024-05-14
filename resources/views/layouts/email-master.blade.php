@php
    $site_color = ( themeOption(setting('core::template', null, '').'::theme_primary_color') != "" ) ? $site_color =
    themeOption(setting('core::template', null, '').'::theme_primary_color') :"#0068a5";
    $lang = (LaravelLocalization::setLocale()) ? LaravelLocalization::setLocale() : "en";
    $logo = (setting('core::site-logo')) ? setting('core::site-logo') : Theme::url('images/logo.png');
    $site_name = (setting('core::site-name')) ? setting('core::site-name') : "Probiocare";
    @endphp

<!DOCTYPE html>
<html lang="{{ $lang  }}" xmlns:o="urn:schemas-microsoft-com:office:office"
    xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <title>{{ $site_name }}</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
    <style>

    </style>
</head>

<body style="background-color: #fafafa; margin: 40px 0px;">
    <table style="width: 100%; max-width: 500px; margin: auto; padding: 20px;">
        <tbody>
            <tr>
                <td>
                    <img style="max-width: 80px; display: block; margin: auto;" src="{{$logo}}">
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%; max-width: 500px; margin: auto; padding: 20px; background-color: #FFFFFF;">
        <tbody>
            <tr>
                <td>
                    <p>
                        @yield('title')
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    @yield('content')
                    
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        <strong>Probiocare</strong><br>
                        This is automated message. Please do not reply!
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>
                        #@yield('customerID')
                    </p>
                </td>
            </tr>
        </tbody>
    </table><!-- End -->
</body>

</html>