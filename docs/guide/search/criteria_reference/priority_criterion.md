# Priority Criterion

`Location\Priority` Search Criterion searches for Locations based on their priority.

This Criterion is available only for Location Search.

## Arguments

- `operator`- Operator constant (GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the priority

## Example

``` php
$query->query = new Criterion\Location\Priority(Criterion\Operator::GTE, 50);
```
