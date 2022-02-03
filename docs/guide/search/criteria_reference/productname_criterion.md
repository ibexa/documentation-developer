# ProductName Criterion

The `ProductName` Search Criterion searches for products by theis names.

## Arguments

- `name` - string representing the Product name, with `*` as wildcard.

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName('sofa*');
```
