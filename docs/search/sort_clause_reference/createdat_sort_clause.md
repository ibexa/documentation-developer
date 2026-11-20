---
description: CreatedAt Sort Clause
---

# CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time of the creation of a product.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\CreatedAt;

$productQuery = new ProductQuery(
    null,
    null,
    [
        new CreatedAt(
            CreatedAt::SORT_ASC
        ),
    ]
);
```
