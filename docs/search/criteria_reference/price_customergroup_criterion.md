---
description: Price CustomerGroup Search Criterion
---

# Price CustomerGroup Criterion

The `CustomerGroup` Search Criterion searches for prices based on the customer group.

## Arguments

- `customer_group` - a single object or an array or `CustomerGroupInterface` objects that represent the customer group (`Ibexa\Contracts\ProductCatalog\Values\CustomerGroupInterface`)

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\CustomerGroupServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\CustomerGroup;

/** @var CustomerGroupServiceInterface $customerGroupService */
$customerGroup = $customerGroupService->getCustomerGroup(123);

$query = new PriceQuery(
    new CustomerGroup($customerGroup)
);
```
