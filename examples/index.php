<?php

require_once "../vendor/autoload.php";
use Olakunlevpn\Gladpaysdk\GladepaySDk;
$class = new GladepaySDk('GP_btZDeSA1N0D4BghvbqvCWrjvISC8GYbr', 'YrYiNqh5ElxSx3nYobSQjM9CFFuVcL2ld9d',false);

var_dump($class->getListOfBill());
