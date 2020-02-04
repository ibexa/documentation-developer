# Priority Criterion

The [`Location\Priority` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/Location/Priority.php)
searches for Locations based on their priority.

This Criterion is available only for Location Search.

## Arguments

- `operator`- Operator constant (GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the priority

The `value` argument requires:

- a list of ints for `Operator::BETWEEN`
- a single int for other Operators

## Example

``` php
$query->query = new Criterion\Location\Priority(Criterion\Operator::GTE, 50);
```
