<?php
    /*
     This PHP code provides a payment form for the Adyen Hosted Payment Pages
     */

    /*
     account details
     $skinCode:        the skin to be used
     $merchantAccount: the merchant account we want to process this payment with.
     $sharedSecret:    the shared HMAC key.
     */

    $skinCode        = "X37I3kWG";
    $merchantAccount = "RentomatoCOM";
    $hmacKey         = "BE737A8F6D0087E25E145BC2F36C68E47154F8FB14645E18CA48A3ECA7691A0B";


    /*
     payment-specific details
     */

    $params = array(
        "merchantReference" => "PaymentTest Rentoamto  1435226439255",
        "merchantAccount"   =>  $merchantAccount,
        "currencyCode"      => "EUR",
        "paymentAmount"     => "180900",
        "sessionValidity"   => date("c", strtotime("+1 days")),
        "shipBeforeDate"    => date("Y-m-d", strtotime("+10 days")),
        "shopperLocale"     => "en_GB",
        "skinCode"          => $skinCode,
        "brandCode"         => "",
        "shopperEmail"      => "vasy.dragan@gmail.com",
        "shopperReference"  => 2,


    );

    // The character escape function
    $escapeval = function($val) {
        return str_replace(':','\\:',str_replace('\\','\\\\',$val));
    };

    // Sort the array by key using SORT_STRING order
    ksort($params, SORT_STRING);

    // Generate the signing data string
    $signData = implode(":",array_map($escapeval,array_merge(array_keys($params), array_values($params))));

    // base64-encode the binary result of the HMAC computation
    $merchantSig = base64_encode(hash_hmac('sha256',$signData,pack("H*" , $hmacKey),true));
    $params["merchantSig"] = $merchantSig;

?>


<!-- Complete submission form -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Adyen Payment</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<form name="adyenForm" action="https://test.adyen.com/hpp/select.shtml" method="post">

    <?php
        foreach ($params as $key => $value){
            echo '        <input type="hidden" name="' .htmlspecialchars($key,   ENT_COMPAT | ENT_HTML401 ,'UTF-8').
                '" value="' .htmlspecialchars($value, ENT_COMPAT | ENT_HTML401 ,'UTF-8') . '" />' ."\n" ;
        }
    ?>
    <input type="submit" value="Submit" />
</form>
</body>
</html>
