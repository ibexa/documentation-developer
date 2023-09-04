---
description: Price CustomerGroup Criterion
---

# Price CustomerGroup Criterion

The `CustomerGroup` Search Criterion searches for prices based on the customer group.

## Arguments

- `customer_group` - a `CustomerGroupInterface` object that represents the customer group (`Ibexa\Contracts\ProductCatalog\Values\CustomerGroupInterface`)

## Example

### PHP

``` php
$customerGroup = $customerGroupService->getCustomerGroup(123);

$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\CustomerGroup($customerGroup)
);
```
