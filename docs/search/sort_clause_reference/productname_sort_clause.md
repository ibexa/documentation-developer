# ProductName Sort Clause

The `ProductName` Sort Clause sorts search results by the Product code.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductName()];
```
