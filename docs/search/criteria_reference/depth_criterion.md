# Depth Criterion

The [`Location\Depth` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Location-Depth.html)
searches for Locations based on their depth in the Content tree.

This Criterion is available only for Location Search.

## Arguments

- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the Location depth(s)

The `value` argument requires:

- a list of ints for `Operator::IN`
- exactly two ints for `Operator::BETWEEN`
- a single int for other Operators

## Example

### PHP

``` php
$query->query = new Criterion\Location\Depth(Criterion\Operator::LT, 3);
```
