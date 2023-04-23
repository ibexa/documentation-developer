---
description: Use PHP API to manage payments n Commerce: create, update and delete payments.
edition: commerce
---

# Payment API

!!! tip "Payment REST API"

    To learn how to manage payments with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#payment).

To get payments and manage them, use the `Ibexa\Contracts\Payment\PaymentServiceInterface` interface.

From the developer's perspective, payments are referenced with a UUID identifier. 

## Get single payment 

### Get single payment by identifier

To access a single payment by using its string identifier, use the `PaymentServiceInterface::getPaymentByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 46, 47) =]]
```

### Get single payment by id

To access a single payment by using its numerical id, use the `PaymentServiceInterface::getPayment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 46, 47) =]]
```

## Get multiple payments

To fetch multiple payments, use the `PaymentServiceInterface::findPayments` method. 
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 46, 47) =]]
```

## Create payment

To create a payment, use the `PaymentServiceInterface::createPayment` method and provide it with 
the `Ibexa\Contracts\Payment\Payment\PaymentCreateStruct` object that passes the following three arguments: `method`, `amount`, and `order`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 46, 47) =]]
```

## Update payment

You can update payment information after the payment is created. 
You could do it to support a scenario when, for example, an online payment failed, has been processed by using other means, and its status has to be updated in the system. 
The `Ibexa\Contracts\Payment\Payment\PaymentUpdateStruct` object passes the following three arguments: `transition`, `identifier`, and `context`.
To update payment information, use the `PaymentServiceInterface::updatePayment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 46, 47) =]]
```

## Delete payment

To delete a payment from the system, use the ``PaymentServiceInterface::deletePayment` method:
``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 46, 47) =]]
```
