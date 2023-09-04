---
description: Price CustomerGroup Criterion
---

# Price CustomerGroup Criterion

The `CustomerGroup` Search Criterion searches for prices based on the customer group ID.

## Arguments

- `customer_group_id` - an int representing the customer group ID

## Example

### PHP

``` php
$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\CustomerGroup(1)
);
```
