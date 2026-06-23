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
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\SourceCriterion('local_shop')
);
```
