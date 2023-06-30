# CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time of the creation of a product.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

``` php
$productQuery = new ProductQuery(
    null,
    null,
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\CreatedAt(
            \Ibexa\Contracts\ProductCatalog\Values\Product\Query\SortClause\CreatedAt::SORT_ASC)
    ]
);
```
