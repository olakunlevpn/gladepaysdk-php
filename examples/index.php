<?php

require_once "../vendor/autoload.php";
use Olakunlevpn\Gladepaysdk\GladepaySDk;
$Glade = new GladepaySDk('GP0000001', '123456789', true); //Change value to true if you are using demo merchant and key

//var_dump($Glade->getListOfBill());

/*
$json_initiate = '
{
    "action":"initiate",
    "paymentType":"card",
    "user": {
        "firstname":"Abubakar",
        "lastname":"Ango",
        "email":"test@gladepay.com",
        "ip":"192.168.33.10",
        "fingerprint": "cccvxbxbxb"
    },
    "card":{
        "card_no":"5438898014560229",
        "expiry_month":"09",
        "expiry_year":"19",
        "ccv":"789",
        "pin":"3310"
    },
    "amount":"10000",
    "country": "NG",
    "currency": "NGN"
}
';
*/
/*
$json_request = json_decode($json_initiate, true);
var_dump($Glade->cardPayment($json_request['user'], $json_request['card'], $json_request['amount'], $json_request['country'], $json_request['currency']));
*/
