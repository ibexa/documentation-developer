---
description: Order Price Criterion
edition: commerce
---

# Order Price Criterion

The `PriceCriterion` searches for orders by their total net value.

## Arguments

- `value` - value to be matched, represents total net order value
- (optional) `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\PriceCriterion(
    12900,
    'GTE'
);

$orderQuery = new OrderQuery($criteria);
```
