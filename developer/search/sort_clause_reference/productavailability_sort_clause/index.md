# ProductAvailability Sort Clause

ProductAvailability Sort Clause

The `ProductAvailability` Sort Clause sorts search results by whether they have availability or not.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;

$query = new ProductQuery(
    null,
    null,
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductAvailability(),
    ]
);
```
