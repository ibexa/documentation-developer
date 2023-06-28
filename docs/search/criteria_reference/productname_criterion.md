# ProductName Criterion

The `ProductName` Search Criterion searches for products by theis names.

## Arguments

- `productName` - string representing the Product name, with `*` as wildcard

## Example

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName('sofa*')
);
```
