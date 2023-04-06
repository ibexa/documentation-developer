---
description: IsCompanyAssociated Criterion
edition: commerce
---

# Order IsCompanyAssociated Criterion

The `IsCompanyAssociatedCriterion` Search Criterion searches for orders based on whether the customer represents a business company.

## Arguments

- `value` - bool that represents whether the customer represents a business company

## Example

``` php
$query->query = new Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\IsCompanyAssociatedCriterion(true);
```
