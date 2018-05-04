<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cancel Contract</title>
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
                                    <p>
                                        Dear {{ $data['tenantName'] }}, <br/><br/>
                                        Please find below a copy of your submission. You will be notified of any follow-up action by us if required.<br/><br/>
                                        Regards,<br/>
                                        Team1stHome <br/><br/><br/> .
                                        Contract end date is last day of: {{ $data['monthName'] }} <br/>
                                        Total months rented: {{ $data['totalMonths']  }} <br/>
                                        Early termination fee: Eur  {{ $data['earlyTerminationFee'] }} , <br/>
                                        Room heating meter value: {{ $data['heatingValue'] }} <br/>
                                        Living room heating meter value (big radiator): {{ $data['lrBigHeatingValue'] }}  <br/>
                                        Living room heating meter value (small  radiator): {{ $data['lrSmallHeatingValue'] }} <br/>
                                        Expected departure date: {{ $data['expectedDepartureDate'] }} <br/>
                                        Willingness to do viewings: {{ $data['viewingremarks'] }} <br/>
                                        Remark: {{ $data['remarks'] }} <br/>
                                    </p>
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