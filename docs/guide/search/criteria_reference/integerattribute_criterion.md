# IntegerAttribute Criterion

The `IntegerAttribute` Search Criterion searches for products by the value of their integer attribute.

## Arguments

-  `identifier` - string representing the attribute.
-  `value` - string representing the attribute value.

## Example

``` php
$query->query = new Product\Query\Criterion\IntegerAttribute('size', 38);
```
