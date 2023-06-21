# ProductAvailability Sort Clause

The `ProductAvailability` Sort Clause sorts search results by whether they have availability or not.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new ProductQuery(
    null,
    null,
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductAvailability()
    ]
);
```
