---
description: Extend Payment with custom payment method type.
edition: commerce
---

# Extend Payment

There are different ways you can extend your Payment module implementation. 
One of them is to create a custom payment method type. 
The other is attaching custom data to a payment.

You can also [customize the payment processing workflow](configure_payment.md#custom_payment_workflows).

## Create custom payment method type

If your application needs payment methods of other type than the default `offline` one, you must create custom payment method types.

!!! note "Gateway integration requirement"

    [[= product_name =]] does not come with gateway redirects. Whether you are an integrator or the end customer, it is your responsibility to implement payment gateway integration.

### Custom payment method type definition

Create a PHP definition of the payment method type.

``` php
[[= include_file('code_samples/front/shop/payment/src/PaymentMethodType/PayPal/PayPal.php') =]]
```

Make sure that `getName` returns a human readable name of the payment method type, the way you want it to appear on the list of available payment method types.

Now, register the definition as a service:

``` yaml
[[= include_file('code_samples/front/shop/payment/config/packages/services.yaml', 0, 5) =]]

```

As an alternative, instead of creating a PHP library, you can use the Type Factory to define the payment method type in your YAML configuration file:

``` yaml
services:
    app.payment.type.paypal: 
        class: Ibexa\Contracts\Payment\PaymentMethod\Type\TypeInterface
        factory: [ '@Ibexa\Contracts\Payment\PaymentMethod\Type\TypeFactoryInterface', 'createType' ]
        arguments: 
            $identifier: 'paypal' 
            $name: 'PayPal' 
        tags: 
            - name: ibexa.payment.payment_method.type 
              alias: paypal

```

At this point a custom payment method type should be visible in the user interface.

### Options form

Create a corresponding form:

``` php
[[= include_file('code_samples/front/shop/payment/src/Form/Type/PayPalOptionsType.php') =]]
```

Next, create a mapper that maps the information that the user inputs in the form into attribute definition.

``` php
[[= include_file('code_samples/front/shop/payment/src/PaymentMethodType/PayPal/OptionsFormMapper.php') =]]
```

Then, register the `OptionsFormMapper` interface as a service:

``` yaml
services:
    App\Payment\PayPal\OptionsFormMapper:
        tags:
            -   name: ibexa.payment.payment_method.options.form_mapper
                type: paypal
```

### Options validator

Finally, make sure the data provided by the user is validated. 
To do that, create an options validator that checks user input against the constraints and dispatches an error when needed.

``` php
[[= include_file('code_samples/front/shop/payment/src/PaymentMethodType/PayPal/UrlOptionValidator.php') =]]
```

Register the validator as a service:

``` yaml
services:
    App\Payment\PayPal\OptionsValidator:
        tags:
            -   name: ibexa.payment.payment_method.options.validator
                type: paypal
```

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
