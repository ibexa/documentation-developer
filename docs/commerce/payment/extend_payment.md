---
description: Extend Payment with custom payment method types.
edition: commerce
---

# Extend Payment

There are different ways you can extend your Payment module implementation. 
One of them is to create a custom payment method type. 
The other is attaching custom data to a payment.

You can also [customize the payment processing workflow](configure_payment.md#custom_payment_workflows).

## Create custom payment method type

If your application needs payment methods of other type than the default `offline` one, you must create custom payment method types. 
Code samples below show how this could be done if your organization wants to use PayPal.

!!! note "Gateway integration requirement"

    [[= product_name =]] does not come with gateway redirects. Whether you are an integrator or an end customer, it is your responsibility to implement payment gateway integration.

### Define custom payment method type

Create a PHP definition of the payment method type.

``` php
[[= include_file('code_samples/front/shop/payment/src/PaymentMethodType/PayPal/PayPal.php') =]]
```

Make sure that `getName()` returns a human-readable name of the payment method type, the way you want it to appear on the list of available payment method types.

Now, register the definition as a service:

``` yaml
[[= include_file('code_samples/front/shop/payment/config/services.yaml', 0, 5) =]]
```

As an alternative, instead of creating a custom class, you can use a built-in type factory to define the payment method type in the service definition file:

``` yaml
[[= include_file('code_samples/front/shop/payment/config/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/payment/config/services.yaml', 6, 15) =]]
```

At this point a custom payment method type should be visible in the user interface.

### Create options form

Create a corresponding form type:

``` php
[[= include_file('code_samples/front/shop/payment/src/Form/Type/PayPalOptionsType.php') =]]
```

Next, create a mapper that maps the information that the user inputs in the form into attribute definition.

``` php
[[= include_file('code_samples/front/shop/payment/src/PaymentMethodType/PayPal/OptionsFormMapper.php') =]]
```

Then, register `OptionsFormMapper` a service:

``` yaml
[[= include_file('code_samples/front/shop/payment/config/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/payment/config/services.yaml', 16, 20) =]]
```

### Create options validator

You might want to make sure that data provided by the user is validated. 
To do that, create an options validator that checks user input against the constraints and dispatches an error when needed.

``` php
[[= include_file('code_samples/front/shop/payment/src/PaymentMethodType/PayPal/UrlOptionValidator.php') =]]
```

Then, register the validator as a service:

``` yaml
[[= include_file('code_samples/front/shop/payment/config/services.yaml', 0, 1) =]][[= include_file('code_samples/front/shop/payment/config/services.yaml', 21, 25) =]]
```

### Restart application

Shut down the application, clear browser cache, and restart the application.
Then, try creating a payment of the new type.

![Payment method of custom type](custom_paymant_type.png "Payment method of custom type")

## Attach custom data to payments

When you create a payment, you can attach custom data to it, for example, you can pass an invoice number or a proprietary transaction identifier.

You add custom data by using the `setContext` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 89, 101) =]]
```

Then, you retrieve it with the `getContext` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 66, 69) =]]
```
