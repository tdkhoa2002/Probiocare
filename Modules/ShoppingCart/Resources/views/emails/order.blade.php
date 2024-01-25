<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }


        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        @media screen and (max-width: 480px) {
            .mobile-hide {
                display: none !important;
            }

            .mobile-center {
                text-align: center !important;
            }
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>

<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">

                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                    <tr>
                        <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#ff6699">

                            <div style="display:inline-block; vertical-align:top; width:100%;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="left" valign="top"
                                            style=" font-size: 36px; font-weight: 800; line-height: 48px;"
                                            class="mobile-center">
                                            <h1
                                                style="font-family: 'Google Sans';font-size: 30px; font-weight: 800; margin: 0; color: #ffffff;text-align:center;">
                                                @setting('core::name-shop')</h1>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;"
                            bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="max-width:600px;">
                                <tr>
                                    <td align="center"
                                        style=" font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                                        <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png"
                                            width="125" height="120" style="display: block; border: 0px;" /><br>
                                        <h2
                                            style="font-family: 'Google Sans';font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                                            Cảm ơn bạn đã đặt hàng
                                        </h2>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left" bgcolor="#eeeeee"
                                                    style="font-family: 'Google Sans'; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                                    Mã đơn hàng #
                                                </td>
                                                <td width="25%" align="left" bgcolor="#eeeeee"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                                    {{ $order->order_code }}
                                                </td>
                                            </tr>
                                            @php
                                            $orderDetails = $order->orderDetails;
                                            @endphp
                                            @foreach ($orderDetails as $orderDetail)
                                            <tr>
                                                <td width="75%" align="left"
                                                    style="font-family: 'Google Sans'; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ $orderDetail->product->title }} ({{ $orderDetail->qty }})
                                                </td>
                                                <td width="25%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ number_format($orderDetail->total) }}đ
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left"
                                                    style="font-family: 'Google Sans'; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                                                    Tổng Tiền
                                                </td>
                                                <td width="25%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                                                    {{ number_format($order->total) }}đ
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td colspan="2" align="left" bgcolor="#eeeeee"
                                                    style="font-family: 'Google Sans'; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                                    Thông tin khách hàng
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    Tên:
                                                </td>
                                                <td width="70%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ $order->fullname }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    Số điện thoại:
                                                </td>
                                                <td width="70%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ $order->phone_number }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    Email:
                                                </td>
                                                <td width="70%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ $order->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    Địa chỉ:
                                                </td>
                                                <td width="70%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ $order->address }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="30%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    Hình thức thanh toán:
                                                </td>
                                                <td width="70%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    <p class="txt">
                                                        @if($order->payment_method == 2)
                                                        Chuyển khoản Ngân hàng
                                                        @else
                                                        Thanh toán Visa
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                            @if($order->time_ship != null)
                                            <tr>
                                                <td width="30%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    Thời gian giao:
                                                </td>
                                                <td width="70%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ $order->time_ship }}
                                                </td>
                                            </tr>
                                            @endif
                                            @if($order->note != null)
                                            <tr>
                                                <td width="30%" align="left"
                                                    style=" font-size: 16px; font-weight: 800; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    Ghi chú:
                                                </td>
                                                <td width="70%" align="left"
                                                    style=" font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                    {{ $order->note }}
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <img src="@setting('core::logo')" width="120" height="70"
                                            style="display: block; border: 0px;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"
                                        style=" font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px 0 10px 0;">
                                        <p
                                            style="font-size: 14px; font-weight: 800; line-height: 18px; color: #333333;">
                                            @setting('core::address')
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>