# ColorAttribute Criterion

The `ColorAttribute` Search Criterion searches for products by the value of their color attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - array of strings representing the attribute values

## Example

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ColorAttribute('color', ['#FF0000'])
);
```
