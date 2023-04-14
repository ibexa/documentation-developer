---
description: Payment Price Criterion
edition: commerce
---

# Payment Price Criterion

The `PriceCriterion` searches for payments by their total value.

## Arguments

- `value` - value to be matched, represents total payment value
- (optional) `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\PriceCriterion(124, 
    Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\Operator::EQ);
$paymentQuery = new PaymentQuery(null, $criteria);
```