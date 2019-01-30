# Depth Criterion

`Location\Depth` Search Criterion searches for Locations based on their depth in the Content tree.

This Criterion is available only for Location Search.

## Arguments

- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the Location depth(s)

## Example

``` php
$query->query = new Criterion\Location\Depth(Criterion\Operator::LT, 3);
```
