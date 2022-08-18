# ProductAvailability Sort Clause

The `ProductAvailability` Sort Clause sorts search results by whether they have availability or not.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new Query();
$query->sortClauses = [new Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductAvailability()];
```
