# ProductType Criterion

The `ProductType` Search Criterion searches for products by their types.

## Arguments

- `types` - string(s) representing the product types(s).

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductType(['sofa', 'chaise']);
```
