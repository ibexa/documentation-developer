# PayPal Express Checkout [[% include 'snippets/commerce_badge.md' %]]

## Installation and configuration

PayPal Express Checkout payment requires the third-party [`JMSPaymentPaypalBundle`](http://jmspaymentpaypalbundle.readthedocs.io/en/stable/setup.html) library.

``` bash
php composer.phar require jms/payment-paypal-bundle
php composer.phar update -- jms/payment-paypal-bundle
```

See [How to get the API credentials](#how-to-get-the-api-credentials) to learn where you can find the values for the `JMSPaymentPaypalBundle` configuration in the PayPal merchant's administration.

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

## How to get the API credentials

Provide your [PayPal API credentials](https://developer.paypal.com/docs/nvp-soap-api/apiCredentials/#api-certificates) in configuration:

``` yaml
jms_payment_paypal:
    username: myusername
    password: mypassword
    signature: A5Va2XJid60kg21ddddddxKbSykH4i.ddsdsd-332yT0G8z8LrvNPl1
    debug: true
```
