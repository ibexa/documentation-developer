---
description: Use PHP API to manage payment methods in Commerce: create, modify and delete payments.
edition: commerce
---

# Payment method API

!!! tip "Payment method REST API"

    To learn how to manage payment methods with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#payment).

To get payment methods and manage them, use the `Ibexa\Contracts\Payment\PaymentMethodServiceInterface` interface.

From the developer's perspective, payment methods are referenced with a UUID identifier. 

## Get single payment method

### Get single payment method by identifier

To access a single payment method by using its string identifier, use the `PaymentMethodService::getPaymentMethodByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 46, 47) =]]
```

### Get single payment method by id

To access a single payment method by using its numerical id, use the `PaymentMethodService::getPaymentMethod` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 46, 47) =]]
```

 ## Get multiple payment methods

To fetch multiple payment methods, use the `PaymentMethodService::findPaymentMethods` method. 
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 46, 47) =]]
```

## Create payment method

To create a payment method, use the `PaymentMethodService::createPaymentMethod` method and provide it with 
the `Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodCreateStruct` object that passes the following parameters:     `identifier` string, `type` TypeInterface object, `names` array of string values, `descriptions` array of string values, `enabled` boolean value, and the `options` object.

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 46, 47) =]]
```

## Update payment method

You can update the payment method after it is created. 
The `Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodUpdateStruct` object can pass the following arguments: `identifier` string, `names` array of string values, `descriptions` array of string values, `enabled` boolean value, and the `options` object.
To update payment method information, use the `PaymentMethodServiceInterface::updatePaymentMethod` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 46, 47) =]]
```

## Delete payment

To delete a payment method from the system, use the ``PaymentMethodService::deletePayment` method:
``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentMethodCommand.php', 46, 47) =]]
```
