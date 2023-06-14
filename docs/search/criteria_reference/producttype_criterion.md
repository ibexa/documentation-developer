# ProductType Criterion

The `ProductType` Search Criterion searches for products by their codes.

## Arguments

- `productType` - array of strings representing the Product type(s)

## Example

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductType(['dress'])
);
```
