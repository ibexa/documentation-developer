---
description: IsProductBased Search Criterion
---

# IsProductBased Criterion

The `IsProductBased` Search Criterion searches for content that plays the role of a Product.

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\ProductCatalog\Values\Content\Query\Criterion\IsProductBased;

$query = new Query();
$query->query = new IsProductBased();
```
