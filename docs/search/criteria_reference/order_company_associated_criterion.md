---
description: Order IsCompanyAssociated Search Criterion
edition: commerce
---

# Order IsCompanyAssociated Criterion

The `IsCompanyAssociatedCriterion` Search Criterion searches for orders based on whether the customer represents a business company.

## Arguments

- `value` - boolean that shows whether the customer represents a business company

## Example

### PHP

``` php
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\IsCompanyAssociatedCriterion;

$query = new OrderQuery(
    new IsCompanyAssociatedCriterion(true)
);
```
