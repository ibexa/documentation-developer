---
description: Use PHP API to manage payments in Commerce. You can create, update and delete payments.
edition: commerce
---

# Payment API

To get payments and manage them, use the `Ibexa\Contracts\Payment\PaymentServiceInterface` interface.

By default, UUID is used to generate payment identifiers. 
You can change that by providing a custom payment identifier in `Ibexa\Contracts\Payment\Payment\PaymentCreateStruct` or `Ibexa\Contracts\Payment\Payment\PaymentUpdateStruct`.

## Get single payment 

### Get single payment by ID

To access a single payment by using its numerical ID, use the `PaymentServiceInterface::getPayment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 59, 63) =]]
```

### Get single payment by identifier

To access a single payment by using its string identifier, use the `PaymentServiceInterface::getPaymentByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 65, 69) =]]
```

## Get multiple payments

To fetch multiple payments, use the `PaymentServiceInterface::findPayments` method. 
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 71, 87) =]]
```

## Create payment

To create a payment, use the `PaymentServiceInterface::createPayment` method and provide it with 
the `Ibexa\Contracts\Payment\Payment\PaymentCreateStruct` object that takes the following arguments: `method`, `order` and `amount`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 93, 98) =]]
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 100, 103) =]]
```

## Update payment

You can update payment information after the payment is created. 
You could do it to support a scenario when, for example, an online payment failed, has been processed by using other means, and its status has to be updated in the system. 
The `Ibexa\Contracts\Payment\Payment\PaymentUpdateStruct` object takes the following arguments: `transition`, `identifier`, and `context`.
To update payment information, use the `PaymentServiceInterface::updatePayment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 105, 111) =]]
```

## Delete payment

To delete a payment from the system, use the `PaymentServiceInterface::deletePayment` method:
``` php
[[= include_file('code_samples/api/commerce/src/Command/PaymentCommand.php', 113, 116) =]]
```
