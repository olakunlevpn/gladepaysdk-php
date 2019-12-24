<?php

require_once "../vendor/autoload.php";
use Olakunlevpn\Gladepaysdk\GladepaySDk;

$merchant_id = "GP0000001"; //To get your live credentials register here https://dashboard.gladepay.com/register
$merchant_key = "123456789"; //To get your live credentials register here https://dashboard.gladepay.com/register

//Auth session with your Merchant ID and Merchant Key
$Glade = new GladepaySDk($merchant_id, $merchant_key, true); //Change value to true if you are using demo merchant ID and key

$payload = $Glade->getWebhookPayload();
$txDetails = $Glade->verifyTransaction($payload['txnRef']);
//$hash = hash('sha512', $payload.$key)



/*
Error Codes
101	Merchant Authentication Failed.
102	Invalid Method Call.
103	Invalid JSON Request.
104	Invalid Data Request.
200	Successful
201	Unrecognized Response From Gateway
202	OTP Validation required
203	Validation not successful
204	An error has occurred


*/
/*
if (isset($txDetails->status) && isset($txDetails->status) == "200") {
    //A sample response from the webhook
/*  $txDetails['status']
    $txDetails['txnStatus']
    $txDetails['chargedAmount']
    $txDetails['paymentMethod']
    $payload['txnRef']
    $payload['endpoint']


    */
/*
    //Your transaction is Successful
} else {
  //No transaction is processed
}
  */
 ?>
