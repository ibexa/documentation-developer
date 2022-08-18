# ProductCategory Criterion

The `ProductCategory` Search Criterion searches for products by the category they are assigned to.

## Arguments

- `taxonomyEntries` - array of ints representing category IDs.

## Example

``` php
$criteria = new Criterion\ProductCategory([2, 3]);

$productQuery = new ProductQuery(null, $criteria);
```
