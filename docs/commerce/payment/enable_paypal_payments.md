---
description: Use Payum to integrate the PayPal payment processing service.
edition: commerce
---

### Enable PayPal payments with Payum

By using Payum to integrate PayPal into your application, you can offer your customers a versatile payment processing service that supports various payment methods, including credit cards, debit cards, Pay Later options, and alternative payment methods.

Before you can proceed with integrating PayPal, you must [create a PayPal business account](https://www.paypal.com/bizsignup/#/singlePageSignup) and obtain API credentials.

Install the PayPal package:

`composer require payum/paypal-express-checkout-nvp php-http/guzzle7-adapter`

Then, add the following configuration to your YAML configuration file (`payum.yaml` or similar):

```yaml
payum:
    gateways:
        pp_express_checkout:
            factory: paypal_express_checkout
            username: <paypal_username>
            password: <paypal_password>
            signature: <paypal_signature>
```

!!! tip

    You can replace `pp_express_checkout` with a different unique identifier.

Ensure that the `username`, `password,` and `signature` fields contain the PayPal API credentials obtained from your PayPal business account.

You can now provide language translations for the PayPal payment service name.
To do it, within the `ibexa_payment_type` namespace in your translation files, use the provided translation key structure for each of your supported languages:

```yaml
ibexa:
    payment_method:
        type:
            pp_express_checkout:
                name: "Translated PayPal Express Checkout name"

```
