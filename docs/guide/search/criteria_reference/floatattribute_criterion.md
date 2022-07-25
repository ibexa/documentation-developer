# FloatAttribute Criterion

The `FloatAttribute` Search Criterion searches for products by the value of their float attribute.

## Arguments

-  `identifier` - string representing the attribute.
-  `value` - string representing the attribute value.

## Example

``` php
$query->query = new Product\Query\Criterion\FloatAttribute('length', 16.5);
```
