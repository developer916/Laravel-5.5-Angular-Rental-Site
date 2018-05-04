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
                                                <h1 style="color: #137bb5; text-align: center;">Hi {{$deposit_relay->tenant_first_name. ' ' . $deposit_relay->tenant_last_name}},</h1>
                                                <table style="margin: 0 5em;">
                                                    <tbody>
                                                    <tr>
                                                        <td style="padding: 0 0 1em;">
                                                            <p>Let's get started with securing your deposit.</p>
                                                            @if($tenantExist == 0)
                                                                <p>Please signed up with <a href="{{$tenantUrl}}" target="_blank" rel="noopener noreferrer">Rentling</a></p>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-top: 1px solid #ddd;">
                                                            <table style="width: 100%;">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="padding: 1em 0;"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/BankBuilding.png" width="40" height="40" /></td>
                                                                    <td style="width: 100%; padding: 1em 0;">
                                                                        <h2 style="padding-left: 16px; text-align: left;">1. Make payment to Rentling.</h2>
                                                                        <table style="width: 333.02203369140625px;">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td style="padding-left: 16px; text-align: left; width: 120px;">Amount</td>
                                                                                <td style="width: 204.02203369140625px;">{{$deposit_relay->rent}}</td>
                                                                            </tr>
                                                                            {{--<tr>--}}
                                                                                {{--<td style="padding-left: 16px; text-align: left; width: 120px;">IBAN</td>--}}
                                                                                {{--<td style="width: 204.02203369140625px;">LT82 3500 0100 0338 6185</td>--}}
                                                                            {{--</tr>--}}
                                                                            {{--<tr>--}}
                                                                                {{--<td style="padding-left: 16px; text-align: left; width: 120px;">BIC code</td>--}}
                                                                                {{--<td style="width: 204.02203369140625px;">EVIULT21XXX</td>--}}
                                                                            {{--</tr>--}}
                                                                            {{--<tr>--}}
                                                                                {{--<td style="padding-left: 16px; text-align: left; width: 120px;">Account name</td>--}}
                                                                                {{--<td style="width: 204.02203369140625px;">Rentling CallCapacity</td>--}}
                                                                            {{--</tr>--}}
                                                                            {{--<tr>--}}
                                                                                {{--<td style="padding-left: 16px; text-align: left; width: 120px;">Transaction code</td>--}}
                                                                                {{--<td style="width: 204.02203369140625px;">{id}</td>--}}
                                                                            {{--</tr>--}}
                                                                            </tbody>
                                                                        </table>
                                                                        <p style="padding-left: 16px; text-align: left;">Important factors:<br /> 1. The account name you pay from should match the name you supplied to&nbsp;Renting. If the names mismatch, the payment is automatically returned.<br /> 2. Mention the&nbsp;transaction code in the payment description.</p>
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
                                                                    <td style="padding: 1em 0;"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/clock.jpg" width="40" height="40" /></td>
                                                                    <td style="width: 100%; padding: 1em 0;">
                                                                        <h2 style="padding-left: 16px; text-align: left;">2.&nbsp;Wait for our e-mail and SMS.</h2>
                                                                        <p style="padding-left: 16px; text-align: left;">Once your payment arrives, you receive a link to log into our system, where you can cancel or speed up the payment to {{$deposit_relay->landlord_name}}.<br /><br />We also notify {{$deposit_relay->landlord_name}} that your deposit payment arrived&nbsp;in our system.</p>
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
                                                                        <h2 style="padding-left: 16px; text-align: left;">3.&nbsp;Move in</h2>
                                                                        <p style="padding-left: 16px; text-align: left;">We will inform landlord you expect to arrive on {{substr($deposit_relay->move_in_date,0,10)}}</p>
                                                                    </td>
                                                                    <td style="padding: 1em 0;"><img width="12" height="20" /></td>
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
                                                                        <h2 style="padding-left: 16px; text-align: left;">4. We pay {{$deposit_relay->landlord_name}}.</h2>
                                                                        <p style="padding-left: 16px; text-align: left;">One day after your move in date, we transfer the deposit payment to  {{$deposit_relay->landlord_name}}</p>
                                                                        <p>&nbsp;</p>
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
                                                <div><span style="white-space: nowrap;">Contact us:&nbsp;<a style="color: #137bb5;" href="mailto:support@Rentling.com">Support@Rentling.group</a>&nbsp;</span></div>
                                                <div><span style="white-space: nowrap;">More about us:&nbsp;<a href="https://www.rentling.group" target="_blank" rel="noopener noreferrer">www.Rentling.group</a> <a href="https://www.youtube.com/channel/UCiC19Lwi9G0g7ajLo0XS1fA" target="_blank" rel="noopener noreferrer"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/youtube-icon.png" width="34" height="24" /></a>&nbsp;<a href="https://www.facebook.com/rentlingdepositprotection/" target="_blank" rel="noopener noreferrer"><img src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/facebook-icon.png" width="28" height="24" /></a></span></div>
                                            </td>
                                        </tr>
                                        {{--<tr>--}}
                                            {{--<td valign="top">--}}
                                                {{--<p style="margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Helvetica Neue; color: #454545;">We will deduct {feefactor}% of your payment, with a minimum of Eur {minimumfee},- or equivalent in your currency. This fee is already included in above calculation.</p>--}}
                                                {{--<p style="margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Helvetica Neue; color: #454545;">If you cancel payment to {landlordName}, we will deduct {cancellationfeefactor}% as cancellation fee and pay half of it to {landlordName}.</p>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                        <tr>
                                            <td valign="top">
                                                <p style="margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Helvetica Neue; color: #454545;">We will deduct 1.9% of your payment, with a minimum of Eur 15,- or equivalent in your currency. This fee is already included in above calculation.</p>
                                                <p style="margin: 0px; font-stretch: normal; font-size: 12px; line-height: normal; font-family: Helvetica Neue; color: #454545;">If you cancel payment to {{$deposit_relay->landlord_name}}, we will deduct 10% as cancellation fee and pay half of it to {{$deposit_relay->landlord_name}}.</p>
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
