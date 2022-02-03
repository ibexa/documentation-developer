# ProductName Sort Clause

The `ProductName` Sort Clause sorts search results by the Product code.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductName()];
```
