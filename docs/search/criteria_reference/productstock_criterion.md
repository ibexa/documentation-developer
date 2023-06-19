# ProductStock Criterion

The `ProductStock` Search Criterion searches for products by their numerical stock.

## Arguments

- `value` - the numerical stock to search for
- (optional) `operator` - operator string (`=` `<` `<=` `>` `>=`)

## Example

``` php
$productQuery = new ProductQuery(
    null,
    new Criterion\ProductStock(10)
);
```

``` php
$productQuery = new ProductQuery(
    null,
    new Criterion\ProductStock(50, '>=')
);
```


