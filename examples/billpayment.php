<?php

//require composer autoload files
require_once "../vendor/autoload.php";

//Include system class
use Olakunlevpn\Gladepaysdk\GladepaySDk;

//Auth session with your Merchant ID and Merchant Key
$class = new GladepaySDk('GP0000001', '123456789', true); //Change value to true if you are using demo merchant and key


//Get all banks by default
//var_dump($class->getAllBanks());


//Get all bill payment list by default
//var_dump($class->getListOfBillAirtime());

//Get all bill payment list by default (Demostrations of stdBlass)
/*$bill = $class->getListOfBillAirtime();
foreach ($bill->data->bills as $key => $value) {
    echo $value->name."<br>";
} */



//Get bill payments by ID
//var_dump($class->getListOfBillById(6));
/*$bill = $class->getListOfBillAirtime();


//Get bill payments by Category
var_dump($bill->data->categories);
*/


//Resolve Bills Name
//var_dump($class->billPaymentResolve('lAApm6OBmRmp3cQ', '0000000001'));
/*$bill = $class->billPaymentResolve('lAApm6OBmRmp3cQ', '0000000001');
echo $bill->status;
echo $bill->message;
echo $bill->custName;
*/


//var_dump($class->makeBillPayment('lAApm6OBmRmp3cQ', '0000000001', 100, 'xxcd'));



/*
$bill = $class->makeBillPayment('lAApm6OBmRmp3cQ', '0000000001', 100, 'xxcd');

if ($bill->status == 200) {
  //transaction is suuccesful
  echo 'transaction is suuccesful (txnRef: '.$bill->txnRef.') ';
}
*/
