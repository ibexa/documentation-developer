# ProductCode Criterion

The `ProductCode` Search Criterion searches for products by their codes.

## Arguments

- `codes` - int(s) representing the Product codes(s).

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductCode([62, 64]);
```
