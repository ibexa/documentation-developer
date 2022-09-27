---
description: You can configure Ibexa DXP to allow PayPal Express Checkout as one of the payment methods.
edition: commerce
---

# PayPal

## Enabling PayPal Express Checkout

PayPal Express Checkout payment requires the third-party `JMSPaymentPaypalBundle` library. 
The library's fork is available at the following [location](https://github.com/ezsystems/JMSPaymentPaypalBundle/releases/tag/v2.0.0).
Make sure that you are using the latest version v2.0.0.

``` bash
php composer.phar require ezsystems/payment-paypal-bundle
php composer.phar update -- ezsystems/payment-paypal-bundle
```

See [How to get the API credentials](#getting-api-credentials) to learn where you can find the values for the `JMSPaymentPaypalBundle` configuration in the PayPal merchant's administration.

Additionally, you must activate `SisoPaypalPaymentBundle` in the kernel, and include the routes:

``` php
return [
    // ...
    Siso\Bundle\PaypalPaymentBundle\SisoPaypalPaymentBundle::class => ['all' => true],
]
```

``` yaml
_siso_paypal_payment:
    resource: '@SisoPaypalPaymentBundle/Resources/config/routing.yml'
```

## Getting API credentials

Provide your [PayPal API credentials](https://developer.paypal.com/docs/nvp-soap-api/apiCredentials/#api-certificates) in configuration:

``` yaml
jms_payment_paypal:
    username: myusername
    password: mypassword
    signature: A5Va2XJid60kg21ddddddxKbSykH4i.ddsdsd-332yT0G8z8LrvNPl1
    debug: true
```
