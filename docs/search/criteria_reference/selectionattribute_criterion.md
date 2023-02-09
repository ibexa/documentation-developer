# SelectionAttribute Criterion

The `SelectionAttribute` Search Criterion searches for products by the value of their selection attribute.

## Arguments

-  `identifier` - string representing the attribute.
-  `value` - string representing the attribute value.

## Example

``` php
$query->query = new Product\Query\Criterion\SelectionAttribute('fabric_type', 'cotton');
```
