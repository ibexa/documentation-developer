---
description: Order Identifier Search Criterion
edition: commerce
---

# Order Identifier Criterion

The `IdentifierCriterion` Search Criterion searches for orders based on the order identifier.

## Arguments

- `identifier` - string that represents the order identifier

## Example

### PHP

``` php
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\IdentifierCriterion;

$query = new OrderQuery(
    new IdentifierCriterion('f7578972-e7f4-4cae-85dc-a7c74610204e')
);
```
