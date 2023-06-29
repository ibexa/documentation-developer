# ProductName Sort Clause

The `ProductName` Sort Clause sorts search results by the Product code.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new ProductQuery(
    null,
    null,
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductName()
    ]
);
```
