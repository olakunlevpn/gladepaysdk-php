<?php

//require composer autoload files
require_once "../vendor/autoload.php";

//Include system class
use Olakunlevpn\Gladepaysdk\GladepaySDk;


$merchant_id = "GP0000001"; //To get your live credentials register here https://dashboard.gladepay.com/register
$merchant_key = "123456789"; //To get your live credentials register here https://dashboard.gladepay.com/register

//Auth session with your Merchant ID and Merchant Key
$Glade = new GladepaySDk($merchant_id, $merchant_key, true); //Change value to true if you are using demo merchant and key


//Get all banks by default
//var_dump($Glade->getAllBanks());


//Get all bill payment list by default
//var_dump($Glade->getListOfBillAirtime());

//Get all bill payment list by default (Demostrations of stdBlass)
/*$bill = $Glade->getListOfBillAirtime();
foreach ($bill->data->bills as $key => $value) {
    echo $value->name."<br>";
} */



//Get bill payments by ID
//var_dump($Glade->getListOfBillById(6));
/*$bill = $Glade->getListOfBillAirtime();


//Get bill payments by Category
var_dump($bill->data->categories);
*/


//Resolve Bills Name
//var_dump($Glade->billPaymentResolve('lAApm6OBmRmp3cQ', '0000000001'));
/*$bill = $Glade->billPaymentResolve('lAApm6OBmRmp3cQ', '0000000001');
echo $bill->status;
echo $bill->message;
echo $bill->custName;
*/


//var_dump($Glade->makeBillPayment('lAApm6OBmRmp3cQ', '0000000001', 100, 'xxcd'));



/*
$bill = $Glade->makeBillPayment('lAApm6OBmRmp3cQ', '0000000001', 100, 'xxcd');

if ($bill->status == 200) {
  //transaction is suuccesful
  echo 'transaction is suuccesful (txnRef: '.$bill->txnRef.') ';
}
*/
