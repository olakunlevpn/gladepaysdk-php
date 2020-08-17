# GladePay PHP

 A Gladepay SDK written in PHP (www.gladepay.com)


 [![Issues](https://img.shields.io/github/issues/olakunlevpn/gladepaysdk-php?style=flat-square)](https://github.com/olakunlevpn/gladepaysdk-php/issues)
 [![Stars](https://img.shields.io/github/stars/olakunlevpn/gladepaysdk-php)](https://github.com/olakunlevpn/gladepaysdk-php/stargazers)
 [![Latest Stable Version](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/v/stable)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)
 [![Total Downloads](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/downloads)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)
 [![Latest Unstable Version](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/v/unstable)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)
 [![License](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/license)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)




> **Note:** This repository contains the Gladepay SDK integrating gladepay.com API into your project. You need a Merchant ID and Key to authenticate against the API register here https://dashboard.gladepay.com/register or use the demo Test API Credentials:
Merchant ID: GP0000001
Merchant Key: 123456789


## 1. Installation

1. Require the package using composer:

    ```
    composer require olakunlevpn/gladepaysdk-php
    ```


## 2. Usage

1. Next, require Composer's autoloader, in your application, to automatically load the Gladpaysdk in your project:
```
require_once "vendor/autoload.php";


use Olakunlevpn\Gladepaysdk\GladepaySDk;

$merchant_id = "GP0000001"; //To get your live credentials register here https://dashboard.gladepay.com/register
$merchant_key = "123456789"; //To get your live credentials register here https://dashboard.gladepay.com/register

//Auth session with your Merchant ID and Merchant Key.
$Glade = new GladepaySDk($merchant_id, $merchant_key, true); //Change value to true if you are using demo merchant and key
```

### Documentation

If you don't understand something about Gladpaysdk SDK, the [extensive documentation](https://developer.gladepay.com/api/) is a great place to look for answers.

## Credits

- [Olakunlevpn](https://github.com/olakunlevpn)
- [All Contributors](https://github.com/olakunlevpn/gladepaysdk-php/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
