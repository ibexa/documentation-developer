---
description: Price Criterion
edition: commerce
---

# Order Price Criterion

The `PriceCriterion` searches for orders by their total net value.

## Arguments

- `value` - value to be matched, represents total net order value
- (optional) `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CreatedAtCriterion(12900, 
    Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\Operator::GTE);

$orderQuery = new OrderQuery(null, $criteria);
```