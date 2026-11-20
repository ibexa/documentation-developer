# ProductName Sort Clause

ProductName Sort Clause

The `ProductName` Sort Clause sorts search results by the Product code.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;

$query = new ProductQuery(
    null,
    null,
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\ProductName(),
    ]
);
```
