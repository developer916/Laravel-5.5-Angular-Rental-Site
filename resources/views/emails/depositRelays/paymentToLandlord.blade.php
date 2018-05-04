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
                                <td style="padding: 0 0 1em;">
                                    <h1 style="color: #137bb5; text-align: center;">Dear {{ $depositRelay->landlord_name }},</h1>
                                    <p> Your new candidate {{ $depositRelay->tenant_first_name. ' '. $depositRelay->tenant_last_name }}  has moved in yesterday into:  </p>
                                    <p> Location : {{ $property->address }}</p>
                                    <p> Move in Date {{ substr($propertyTenant->start_date,0,10) }}</p>
                                    <p> We have transferred their deposit to your account. </p>
                                    <p>Tenant will make a video and pictures of the accomodation and store them with Rentling to avoid later deposit disputes. Once they arrive, we will send you an email to check and confirm that the pictures and video are accurate.</p>
                                    <p>Regards,</p>
                                    <p>The Rentling team</p>
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