---
description: Order Source Search Criterion
edition: commerce
---

# Order Source Criterion

The `SourceCriterion` Search Criterion searches for orders based on the source of the order.

## Arguments

- `source` - string that represents the source of the order

## Example

### PHP

``` php
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\SourceCriterion;

$query = new OrderQuery(
    new SourceCriterion('local_shop')
);
```
