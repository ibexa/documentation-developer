# ProductType Criterion

The `ProductType` Search Criterion searches for products by their codes.

## Arguments

- `types` - string(s) representing the Product type(s).

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductType(['dress']);
```
