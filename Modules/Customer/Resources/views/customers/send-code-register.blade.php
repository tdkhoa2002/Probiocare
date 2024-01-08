@extends('layouts.email-master')

@php
  $customer_name = $customer->firstname;
  $customer_id = $customer->id;
  $link = route('fe.customer.customer.verifyRegister').'?email='.$customer->email.'&code='.$code;
@endphp


@section('title')
Verify Your Email!
@stop
@section('customerID')
{{$customer_id}}
@stop

@section('content')

<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #eeeeee;" width="100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                    role="presentation"
                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 600px;"
                    width="600">
                    <tbody>
                        <tr>
                            <td class="column column-1"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 10px; padding-left: 10px; padding-right: 10px; padding-top: 10px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-1"
                                    role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td class="pad">
                                            <div
                                                style="color:#000000;direction:ltr;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:16px;font-weight:400;letter-spacing:0px;line-height:180%;text-align:left;mso-line-height-alt:28.8px;">
                                                <p style="margin: 0;">
                                                    Hi {{$customer_name}},
                                                    <br /><br />Your verification code will be valid for 30 minutes. Please do not share this code with anyone. Please click on the button to verify your account! <br /><br />
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="10" cellspacing="0" class="button_block block-2"
                                    role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                    width="100%">
                                    <tr>
                                        <td class="pad">
                                            <div align="center" class="alignment">
                                                <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="/#" style="height:38px;width:80px;v-text-anchor:middle;" arcsize="11%" stroke="false" fillcolor="#0068a5"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:14px"><![endif]--><a
                                                    style="text-decoration:none;display:inline-block;color:#353535;background-color:#eeeeee;border-radius:4px;width:auto;border-top:0px solid transparent;font-weight:400;border-right:0px solid transparent;border-bottom:0px solid transparent;border-left:0px solid transparent;padding-top:5px;padding-bottom:5px;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size:14px;text-align:center;mso-border-alt:none;word-break:keep-all;"
                                                    target="_blank"><span
                                                        style="padding-left:20px;padding-right:20px;font-size:30px;display:inline-block;letter-spacing:5px;"><span
                                                            style="word-break: break-word; line-height: 40px;">{{$code}}</span></span></a>
                                                <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-1"
                                    role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td class="pad">
                                            <div
                                                style="color:#000000;direction:ltr;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:16px;font-weight:400;letter-spacing:0px;line-height:180%;text-align:left;mso-line-height-alt:28.8px;">
                                                <p style="margin: 0;">
                                                    Or copy the link here to browser: <br />
                                                    {{$link}}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

@stop

@section('email-note')
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation"
    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #eeeeee;" width="100%">
    <tbody>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack"
                    role="presentation"
                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 600px;"
                    width="600">
                    <tbody>
                        <tr>
                            <td class="column column-1"
                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 10px; padding-left: 10px; padding-right: 10px; padding-top: 10px; vertical-align: middle; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-1"
                                    role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                    width="100%">
                                    <tr>
                                        <td class="pad">
                                            <div align="center" class="alignment">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                    <tr>
                                                        <td class="divider_inner"
                                                            style="font-size: 1px; line-height: 1px; border-top: 1px solid #dddddd;">
                                                            <span> </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0" class="paragraph_block block-2"
                                    role="presentation"
                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                                    width="100%">
                                    <tr>
                                        <td class="pad">
                                            <div
                                                style="color:#000000;direction:ltr;font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:12px;font-weight:400;letter-spacing:0px;line-height:180%;text-align:left;mso-line-height-alt:21.6px;">
                                                <p style="margin: 0;">* Automated message. Please do not reply!</p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <table border="0" cellpadding="0" cellspacing="0" class="divider_block block-3"
                                    role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                    width="100%">
                                    <tr>
                                        <td class="pad">
                                            <div align="center" class="alignment">
                                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                                    style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                                    <tr>
                                                        <td class="divider_inner"
                                                            style="font-size: 1px; line-height: 1px; border-top: 1px solid #dddddd;">
                                                            <span> </span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
@stop

