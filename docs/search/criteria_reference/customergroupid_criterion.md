---
description: CustomerGroupId Search Criterion
---

# CustomerGroupId Criterion

The `CustomerGroupId` Search Criterion searches for content based on the ID of its customer group.

## Arguments

- `value` - int(s) representing the customer group ID(s)

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\ProductCatalog\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\CustomerGroupId(1);
```
