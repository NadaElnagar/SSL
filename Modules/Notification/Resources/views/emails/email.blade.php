<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <!-- Header -->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                   style="border: 1px solid #cccccc; border-collapse: collapse;">
                <tr>
                    <td class="p30-15-0" style="padding: 40px 30px 0px 30px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <th class="column"
                                    style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="img m-center"
                                                style="font-size:0pt; line-height:0pt; text-align:left;"><img
                                                    src="{{asset('public/logo.png')}}" width="191" height="24"
                                                    border="0" alt=""/></td>
                                        </tr>
                                    </table>
                                </th>
                                <th class="column-empty" width="1"
                                    style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;"></th>
                                <th class="column" width="120"
                                    style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="text-header right"
                                                style="color:#000000; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;">
                                                <h1>@if(isset($website_name)){{$website_name}}@endif</h1>
                                            </td>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                        </table>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="separator"
                                    style="padding-top: 40px; border-bottom:4px solid #000000; font-size:0pt; line-height:0pt;">
                                    &nbsp;
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- END Header -->
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                   style="border: 1px solid #cccccc; border-collapse: collapse;">

                <tr>
                    <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                    <b>@if(isset($title)){{$title}}@endif</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                    @if(isset($body)){!!  $body !!}@endif
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;"
                                    width="75%">
                                    &reg; All Copy Rights, PowerBy PAM 2007<br/>
                                </td>
                                <td align="right" width="25%">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                <a href="https://panarab-media.com/" style="color: #ffffff;">
                                                    <img src="{{asset('public/logo.png')}}" alt="Twitter" width="38"
                                                         height="38" style="display: block;" border="0"/>
                                                </a>
                                            </td>
                                            <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                        </tr>
                                    </table>
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
