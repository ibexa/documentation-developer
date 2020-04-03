# Depth Criterion

The [`Location\Depth` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/tree/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/Location)
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

``` php
$query->query = new Criterion\Location\Depth(Criterion\Operator::LT, 3);
```
