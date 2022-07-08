# ColorAttribute Criterion

The `ColorAttribute` Search Criterion searches for products by the value of their color attribute.

## Arguments

-  `identifier` - string representing the attribute.
-  `value` - string representing the attribute value.

## Example

``` php
$query->query = new Product\Query\Criterion\ColorAttribute('color', '#FF0000');
```
