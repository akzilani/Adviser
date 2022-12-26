<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Regulated Advice</title>
        <style type="text/css">
            @import url(http://fonts.googleapis.com/css?family=Lato:400);

            /* Take care of image borders and formatting */

            img {
                max-width: 600px;
                outline: none;
                text-decoration: none;
                -ms-interpolation-mode: bicubic;
            }

            a {
                text-decoration: none;
                border: 0;
                outline: none;
                color: #21BEB4;
            }

            a img {
                border: none;
            }

            /* General styling */

            td, h1, h2, h3  {
                font-family: Helvetica, Arial, sans-serif;
                font-weight: 400;
            }

            body {
                -webkit-font-smoothing:antialiased;
                -webkit-text-size-adjust:none;
                width: 100%;
                height: 100%;
                color: #37302d;
                background: #ffffff;
            }

            table {
                background:
            }

            h1, h2, h3 {
                padding: 0;
                margin: 0;
                color: #ffffff;
                font-weight: 400;
            }

            h3 {
                color: #21c5ba;
                font-size: 24px;
            }
        </style>

        <style type="text/css" media="screen">
            @media screen {
                /* Thanks Outlook 2013! http://goo.gl/XLxpyl*/
                td, h1, h2, h3 {
                    font-family: 'Lato', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
                }
            }
        </style>

        <style type="text/css" media="only screen and (max-width: 480px)">
            /* Mobile styles */
            @media only screen and (max-width: 480px) {
                table[class="w320"] {
                    width: 320px !important;
                }

                table[class="w300"] {
                    width: 300px !important;
                }

                table[class="w290"] {
                    width: 290px !important;
                }

                td[class="w320"] {
                    width: 320px !important;
                }

                td[class="mobile-center"] {
                    text-align: center !important;
                }

                td[class="mobile-padding"] {
                    padding-left: 20px !important;
                    padding-right: 20px !important;
                    padding-bottom: 20px !important;
                }
            }
        </style>
    </head>
    <body class="body" style="padding:0; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
        <div>
            {!! $mail_message ?? "" !!}
        </div>
        <table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%" >
            <tr>
                <td align="center" valign="top" bgcolor="#ffffff"  width="100%">
                    <table cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                            <td valign="top">
                                <center>
                                    <table cellspacing="0" cellpadding="0" width="500" class="w320">
                                        <tr>
                                            <td>

                                                <table cellspacing="0" cellpadding="0" width="100%">
                                                    <tr>
                                                        <td class="mobile-padding" style="text-align:left;">
                                                        <br><br>

                                                        Login Details <hr>
                                                        Login URL : <a href="{{ url('/login') }}">{{ url('/login') }}</a> <br>
                                                        Email: {{ $advisor->email }}<br>
                                                        Password: ******** <br>

                                                        <br>
                                                        Personal Information <hr>
                                                            Full Name: {{ $advisor->first_name }} {{ $advisor->last_name }}
                                                            <br>
                                                            Email: {{ $advisor->email }}
                                                            <br>
                                                            Phone: {{ $advisor->phone }}
                                                            <br>
                                                            Telephone: {{ $advisor->telephone }}
                                                            <br>
                                                            Personal FCA: {{ $advisor->personal_fca_number }}
                                                            <br>
                                                            Profession: {{ $advisor->profession->name ?? "" }}
                                                            <br>
                                                            Plan: {{ $advisor->subscription_plan->name ?? "" }}
                                                            <br> <br><br>
                                                            Address Information <hr>
                                                            Address Line One: {{ $advisor->address_line_one }}
                                                            <br>
                                                            Address Line Two: {{ $advisor->address_line_two }}
                                                            <br>
                                                            Town: {{ $advisor->town }}
                                                            <br>
                                                            County: {{ $advisor->country }}
                                                            <br>
                                                            Postcode: {{ $advisor->post_code }}
                                                            <br>
                                                            Postcode Area Covered: {{ $advisor->postcodesCovered() }}
                                                            <br>
                                                            Region: {{ $advisor->primary_reason->name ?? "" }}
                                                            <br>

                                                            <br><br>

                                                            Firm Details <hr>
                                                            Firm Name: {{ $advisor->firm_details->profile_name ?? "" }} <br>
                                                            Firm Details: {{ $advisor->firm_details->profile_details ?? "" }} <br>
                                                            Firm FCA Number: {{ $advisor->firm_details->firm_fca_number ?? "" }} <br>
                                                            Firm Website: {{ $advisor->firm_details->firm_website_address ?? "" }} <br>
                                                            <hr>
                                                            Minimum Fund Size: {{ $advisor->fund_size->name }}

                                                            <br> <br><br>

                                                            Services Offered <hr>
                                                            @foreach($advisor->service_offered() as $offer)
                                                                {!! $offer->name !!} <br>
                                                            @endforeach

                                                            <br><br>
                                                            Billing Address <hr>
                                                            Name:  {{ $advisor->billing_info->contact_name ?? "" }} <br>
                                                            Company name: {{ $advisor->billing_info->billing_company_name ?? "" }} <br>
                                                            Company FCA Number: {{ $advisor->billing_info->billing_company_fca_number ?? "" }} <br>
                                                            Address Line One: {{ $advisor->billing_info->billing_address_line_one ?? "" }} <br>
                                                            Address Line Two: {{ $advisor->billing_info->billing_address_line_two ?? "" }} <br>
                                                            Town: {{ $advisor->billing_info->billing_town ?? "" }} <br>
                                                            County: {{ $advisor->billing_info->billing_country ?? "" }} <br>
                                                            Postcode: {{ $advisor->billing_info->billing_post_code ?? "" }} <br>
                                                            <br><br>
                                                            Regulated Advice

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                    </table>
                                </center>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
        <div style="margin-top:15px;">
            {!! $mail_footer ?? ""!!}
        </div>
    </body>
</html>
