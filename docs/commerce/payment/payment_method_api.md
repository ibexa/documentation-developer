---
description: Use PHP API and REST API to manage payment methods in Commerce. You can create, modify and delete payment methods.
edition: commerce
---

# Payment method API

!!! tip "Order management REST API"

    To learn how to manage payment methods with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#payment-methods).
    
To get payment methods and manage them, use the `Ibexa\Contracts\Payment\PaymentMethodServiceInterface` interface.

From the developer's perspective, payment methods are referenced with identifiers defined manually at method creation stage in user interface. 

!!! note "Support for multilingual applications"

    The `getPaymentMethodByIdentifier`, `getPaymentMethod` and `findPaymentMethods` methods take a second argument, `$prioritizedLanguages`, that can be an array of language codes or `null`.
    If there are language codes in an array, methods return payment method name translations in the specified languages.
    Translations come from the database.

## Get single payment method

### Get single payment method by identifier

To access a single payment method by using its string identifier, use the `PaymentMethodService::getPaymentMethodByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 52, 56) =]]
```

### Get single payment method by ID

To access a single payment method by using its numerical ID, use the `PaymentMethodService::getPaymentMethod` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 46, 50) =]]
```

## Get multiple payment methods

To fetch multiple payment methods, use the `PaymentMethodService::findPaymentMethods` method. 
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 58, 75) =]]
```

## Create payment method

To create a payment method, use the `PaymentMethodService::createPaymentMethod` method and provide it with 
an `Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodCreateStruct` object that takes the following parameters: 
`identifier` string, `type` TypeInterface object, `names` array of string values, `descriptions` array of string values, `enabled` boolean value, and an `options` object.

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 58, 59) =]][[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 77, 87) =]]
```

## Update payment method

You can update the payment method after it is created. 
An `Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodUpdateStruct` object can take the following arguments: `identifier` string, `names` array of string values, `descriptions` array of string values, `enabled` boolean value, and an `options` object.
To update payment method information, use the `PaymentMethodServiceInterface::updatePaymentMethod` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 89, 99) =]]
```

## Delete payment method

To delete a payment method from the system, use the `PaymentMethodService::deletePayment` method:
``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 101, 107) =]]
```

## Check whether payment method is used

To check whether a payment method is used, for example, before you delete it, use the `PaymentMethodService::isPaymentMethodUsed` method:
``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 109, 122) =]]
```