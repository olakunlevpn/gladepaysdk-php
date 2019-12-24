<?php

//require composer autoload files
require_once "../vendor/autoload.php";

//Include system class
use Olakunlevpn\Gladepaysdk\GladepaySDk;


$merchant_id = "GP0000001"; //To get your live credentials register here https://dashboard.gladepay.com/register
$merchant_key = "123456789"; //To get your live credentials register here https://dashboard.gladepay.com/register

//Auth session with your Merchant ID and Merchant Key
$Glade = new GladepaySDk($merchant_id, $merchant_key, true); //Change value to true if you are using demo merchant and key

//var_dump($Glade->createSavings());
/*
$names ="John Doe";
$reference = "105158623293";
$email = "email@email.com";
var_dump($Glade->createPersonalizedAccount($names, $reference, $email));



*/
?>
