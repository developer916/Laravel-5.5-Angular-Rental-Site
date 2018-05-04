<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rentling deposit relay - Next steps</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
</head>
<body>

<table id="backgroundTable" border="0" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table style="background-color: white; margin: 20px;" border="0" width="600" cellspacing="0" cellpadding="0">
                <tbody><!-- Header -->
                <tr>
                    <td align="center" valign="top">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td style="padding: 24px; width: 100%; color: #f9f9f9; background-color: #ffffff; font-family: Open Sans, Arial, sans-serif; font-size: 34px; font-weight: bold; line-height: 100%; text-align: center; vertical-align: middle;"><img style="width: 69px; height: 91px;" src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHomeLogo-body-only.png" alt="logo" /></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- Body -->
                <tr>
                    <td align="center" valign="top">
                        <table border="0" width="100%" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td valign="top"><!-- // Begin Module: Standard Content \\ -->
                                    <table border="0" width="100%" cellspacing="0" cellpadding="20">
                                        <tbody>
                                        <tr>
                                            <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd;" valign="top">
                                                <h1 style="color: #137bb5; text-align: center;">Hi {{ $deposit_relay->landlord_name }},</h1>
                                                <table style="margin: 0 5em;">
                                                    <tbody>
                                                    <tr>
                                                        <td style="padding: 0 0 1em;">
                                                            <p>Thank you for signing up with&nbsp;@if($landlordExist == 0) <a href="{{$landlordUrl}}" target="_blank" rel="noopener noreferrer">Rentling</a> @else Rentling @endif to manage a&nbsp;deposit payment.</p>

                                                        </td>
                                                    </tr>
                                                    {{--<tr>--}}
                                                        {{--<td style="border-top: 1px solid #ddd;">--}}
                                                            {{--<table style="width: 100%;">--}}
                                                                {{--<tbody>--}}
                                                                {{--<tr>--}}
                                                                    {{--<td style="padding: 1em 0;"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/BankBuilding.png" width="40" height="40" /></td>--}}
                                                                    {{--<td style="width: 100%; padding: 1em 0;">--}}
                                                                        {{--<h2 style="padding-left: 16px; text-align: left;">1. Check your IBAN.</h2>--}}
                                                                        {{--<table style="width: 314px;">--}}
                                                                            {{--<tbody>--}}
                                                                            {{--<tr>--}}
                                                                                {{--<td style="padding-left: 16px; text-align: left; width: 80.953125px;">Your IBAN</td>--}}
                                                                                {{--<td style="width: 221.046875px;">&nbsp;{landlordIBAN}</td>--}}
                                                                            {{--</tr>--}}
                                                                            {{--</tbody>--}}
                                                                        {{--</table>--}}
                                                                    {{--</td>--}}
                                                                    {{--<td style="padding: 1em 0;">&nbsp;</td>--}}
                                                                {{--</tr>--}}
                                                                {{--</tbody>--}}
                                                            {{--</table>--}}
                                                        {{--</td>--}}
                                                    {{--</tr>--}}
                                                    <tr>
                                                        <td style="border-top: 1px solid #ddd;">
                                                            <table style="width: 100%;">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="padding: 1em 0;"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/clock.jpg" width="40" height="40" /></td>
                                                                    <td style="width: 100%; padding: 1em 0;">
                                                                        <h2 style="padding-left: 16px; text-align: left;">1.&nbsp;Wait for our e-mail and SMS.</h2>
                                                                        <p style="padding-left: 16px; text-align: left;">We will&nbsp;notify you once&nbsp;the deposit payment arrives in our system.</p>
                                                                    </td>
                                                                    <td style="padding: 1em 0;">&nbsp;</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-top: 1px solid #ddd;">
                                                            <table style="width: 100%;">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="padding: 1em 0;"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHome-House.png" width="40" height="40" /></td>
                                                                    <td style="width: 100%; padding: 1em 0;">
                                                                        <h2 style="padding-left: 16px; text-align: left;">2. Let {{ $deposit_relay->tenant_first_name. ' '. $deposit_relay->tenant_last_name }} move in.</h2>
                                                                    </td>
                                                                    <td style="padding: 1em 0;">&nbsp;</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-top: 1px solid #ddd;">
                                                            <table style="width: 100%;">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="padding: 1em 0;"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/MoneyBag1.jpg" width="40" height="40" /></td>
                                                                    <td style="width: 100%; padding: 1em 0;">
                                                                        <h2 style="padding-left: 16px; text-align: left;">3. We send you the deposit.</h2>
                                                                        <p style="padding-left: 16px; text-align: left;">One day after {{ $deposit_relay->tenant_first_name. ' '. $deposit_relay->tenant_last_name }} has&nbsp;moved in, we transfer the deposit payment to your IBAN.</p>
                                                                    </td>
                                                                    <td style="padding: 1em 0;">&nbsp;</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <!-- Footer -->
                <tr>
                    <td align="center" valign="top">
                        <table style="color: #999; background-color: #f1f1f1; border: 1px solid #ddd; text-align: center;" width="100%" cellspacing="0" cellpadding="10">
                            <tbody>
                            <tr>
                                <td valign="top">
                                    <table border="0" width="100%" cellspacing="0" cellpadding="10">
                                        <tbody>
                                        <tr>
                                            <td colspan="2" valign="middle">
                                                <div><span style="white-space: nowrap;">&nbsp;<a style="color: #137bb5;" href="mailto:Info@Rentling.com">Info@Rentling.group</a></span></div>
                                                <div><span style="white-space: nowrap;">More about us:&nbsp;<a href="https://www.rentling.group" target="_blank" rel="noopener noreferrer">www.Rentling.group</a>&nbsp;<a href="https://www.youtube.com/channel/UCiC19Lwi9G0g7ajLo0XS1fA" target="_blank" rel="noopener noreferrer"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/youtube-icon.png" width="34" height="24" /></a>&nbsp;<a href="https://www.facebook.com/rentlingdepositprotection/" target="_blank" rel="noopener noreferrer"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/facebook-icon.png" width="28" height="24" /></a>&nbsp;</span></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <p style="margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Helvetica Neue; color: #454545;">If {{ $deposit_relay->tenant_first_name. ' '. $deposit_relay->tenant_last_name }} cancels payment after we received it, we will deduct 10% as cancellation fee and pay half of it to you.</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                <div><em>Copyright &copy; 2018 Rentling, All rights reserved.</em> <br /><br /></div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>



</body>
</html>