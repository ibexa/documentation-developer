# CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time of the creation of a product.

## Arguments

- `sortDirection` (optional) - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`.

## Example

``` php
$productQuery = new ProductQuery(
    null,
    $criteria,
    [
        new CreatedAt(CreatedAt::SORT_ASC)
    ]
);
```
