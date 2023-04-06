---
description: CompanyName Criterion
edition: commerce
---

# Order CompanyName Criterion

The `CompanyNameCriterion` Search Criterion searches for orders based on the name of the company.

## Arguments

- `company_name` - string that represents a name of the company, with `*` as wildcard

## Example

``` php
$query->query = new Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CompanyNameCriterion('IBM');
```
