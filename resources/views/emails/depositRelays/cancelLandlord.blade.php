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
                                <td style="padding: 24px; width: 100%; color: #f9f9f9; background-color: #ffffff; font-family: Open Sans, Arial, sans-serif; font-size: 34px; font-weight: bold; line-height: 100%; text-align: center; vertical-align: middle;">
                                    <img style="width: 69px; height: 91px;" src="https://s3.eu-central-1.amazonaws.com/rentling/rentling_email_assets/1stHomeLogo-body-only.png" alt="logo" />
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd;" valign="top">
                        <table style="margin: 0 5em;">
                            <tbody>
                            <tr>
                                @if($type == 'tenant')
                                    <td style="padding: 0 0 1em;">
                                        <h1 style="color: #137bb5; text-align: center;">Dear {{ $depositRelay->landlord_name }},</h1>
                                        <p> Candidate {{ $depositRelay->tenant_first_name. ' '. $depositRelay->tenant_last_name }} has cancelled the deposit relay in the Rentling system for the following address and date: </p>
                                        <p> Address : {{ $property->address }}</p>
                                        <p> Move in Date {{ substr($depositRelay->move_in_date,0,10) }}</p>
                                        <p>The reason for cancellation was: {{$depositRelay->cancel_reason}}</p>
                                        <p>If we had already received the deposit in a Rentling account, it will be returned to {{ $depositRelay->landlord_email}}</p>
                                        <p>Regards,</p>
                                        <p>The Rentling team</p>
                                    </td>
                                @else
                                    <td style="padding: 0 0 1em;">
                                        <h1 style="color: #137bb5; text-align: center;">Dear {{ $depositRelay->landlord_name }},</h1>
                                        <p> You have cancelled the deposit relay in the Rentling system for the following address and date: </p>
                                        <p> Address : {{ $property->address }}</p>
                                        <p> Move in Date {{ substr($depositRelay->move_in_date,0,10) }}</p>
                                        <p>The reason for cancellation was: {{$depositRelay->cancel_reason}}</p>
                                        <p>If you had already transferred the deposit to Rentling account, it will be returned to {{ $depositRelay->landlord_email}}</p>
                                        <p>Regards,</p>
                                        <p>The Rentling team</p>
                                    </td>
                                @endif
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