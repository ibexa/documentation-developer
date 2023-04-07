---
description: Source Criterion
edition: commerce
---

# Order Source Criterion

The `SourceCriterion` Search Criterion searches for orders based on the source of the order.

## Arguments

- `source` - string that represents the source of the order

## Example

``` php
$query->query = new Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\SourceCriterion('local_shop');
```
