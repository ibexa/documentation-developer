# CheckboxAttribute Criterion

The `CheckboxAttribute` Search Criterion searches for products by the value of their checkbox attribute.

## Arguments

-  `identifier` - string representing the attribute.
-  `value` - bool representing the attribute value.

## Example

``` php
$query->query = new Product\Query\Criterion\CheckboxAttribute('automatic', true);
```
