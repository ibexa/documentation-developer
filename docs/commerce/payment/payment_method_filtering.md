---
description: Implement payment method filtering.
edition: commerce
---

# Implement payment method filtering

You can use payment method filtering to decide, whether selected payment method can be used and displayed in checkout process.
To allow this filtering, you need to create custom payment method type and register new voter.

## Create custom payment method type

There are different ways you can extend your Payment module implementation. 
One of them is to [create a custom payment method type](extend_payment.md). 

The following example shows, how to create `New Payment Method Type`.

### Define custom payment method type

First, register new payment method type as a service:

``` yaml
[[= include_file('code_samples/front/shop/payment/src/bundle/Resources/config/services/payment_method.yaml', 0, 10) =]]
```

In the `arguments` list provide a name of the payment method type, the way you want it to appear on the list of available payment method types, in the following example: `New Payment Method Type`.

At this point a custom payment method type should be visible in the user interface.

### Create voter for new payment method type

Now, create a `NewPaymentMethodTypeVoter.php` file with the voter definition for your new payment method type:

``` php
[[= include_file('code_samples/front/shop/payment/src/src/lib/PaymentMethod/Voter/NewPaymentMethodTypeVoter.php') =]]
```

Created voter decides, if selected payment method type can be used and displayed in checkout process.

#### Register new voter

Register new voter as a service:

``` yaml
[[= include_file('code_samples/front/shop/payment/src/bundle/Resources/config/services/payment_method.yaml', 11, 14) =]]
```

#### Restart application

Now, clear the cache by running the following command:

``` bash
php bin/console cache:clear
```

Then, try creating a payment of the new type.

![New payment method type](new_payment_method_type.png "New payment method type")