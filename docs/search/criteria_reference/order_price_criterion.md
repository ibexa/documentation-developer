---
description: Order Price Search Criterion
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
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\PriceCriterion;

$criteria = new PriceCriterion(
    12900,
    'GTE'
);

$orderQuery = new OrderQuery($criteria);
```
