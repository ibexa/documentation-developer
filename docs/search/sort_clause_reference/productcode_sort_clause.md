---
description: ProductCode Sort Clause
---

# ProductCode Sort Clause

The `ProductCode` Sort Clause sorts search results by the product code.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new ProductQuery(
    null,
    null,
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductCode()
    ]
);
```
