---
description: Payment Method Type Search Criterion
edition: commerce
---

# Payment Method Type Criterion

The `Type` Search Criterion searches for payment methods based on payment method type.

## Arguments

- `type` - string that represents a payment method type

## Example

### PHP

``` php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Type;
use Ibexa\Contracts\Payment\PaymentMethod\Type\TypeRegistryInterface;

/** @var TypeRegistryInterface $paymentMethodTypeRegistry */
$paymentMethodType = $paymentMethodTypeRegistry->getPaymentMethodType('offline');

$query = new PaymentMethodQuery(
    new Type($paymentMethodType)
);
```
