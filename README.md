# GladePay PHP

 A Gladepay SDK written in PHP


 [![Issues](https://img.shields.io/github/issues/olakunlevpn/gladepaysdk-php?style=flat-square)](https://github.com/olakunlevpn/gladepaysdk-php/issues)
 [![Stars](https://img.shields.io/github/stars/olakunlevpn/gladepaysdk-php)](https://github.com/olakunlevpn/gladepaysdk-php/stargazers)
 [![Latest Stable Version](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/v/stable)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)
 [![Total Downloads](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/downloads)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)
 [![Latest Unstable Version](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/v/unstable)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)
 [![License](https://poser.pugx.org/olakunlevpn/gladepaysdk-php/license)](https://packagist.org/packages/olakunlevpn/gladepaysdk-php)




**Note:** Currently under development

## 1. Installation

1. Require the package using composer:

    ```
    composer require olakunlevpn/gladepaysdk-php
    ```


## 2. Usage

1. Next, require Composer's autoloader, in your application, to automatically load the Gladpaysdk in your project:
```
require_once "vendor/autoload.php";


use Olakunlevpn\Gladpaysdk\GladepaySDk;

$merchant_id = "GP0000001"; //To get your live credentials register here https://dashboard.gladepay.com/register
$merchant_key = "123456789"; //To get your live credentials register here https://dashboard.gladepay.com/register

//Auth session with your Merchant ID and Merchant Key
$Glade = new GladepaySDk($merchant_id, $merchant_key, true); //Change value to true if you are using demo merchant and key
```


## Contributing

Please see [CONTRIBUTING](https://github.com/olakunlevpn/gladepaysdk-php/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Olakunlevpn](https://github.com/olakunlevpn)
- [All Contributors](https://github.com/olakunlevpn/gladpaysdk-php/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
