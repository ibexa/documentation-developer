---
description: Payment PaymentMethod Search Criterion
edition: commerce
---

# Payment PaymentMethod Criterion

The `PaymentMethod` Search Criterion searches for payments based on a payment method applied to them.

## Arguments

- `method_id` - integer that represents an ID of the payment method that you want to match

## Example

### PHP

``` php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\PaymentMethod;
use Ibexa\Contracts\Payment\PaymentMethodServiceInterface;

/** @var PaymentMethodServiceInterface $paymentMethodService */
$paymentMethod = $paymentMethodService->getPaymentMethod(2);

$query = new PaymentQuery(
    new PaymentMethod($paymentMethod)
);
```
