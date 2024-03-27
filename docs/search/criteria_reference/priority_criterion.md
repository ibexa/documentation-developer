# Priority Criterion

The [`Location\Priority` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Location-Priority.html)
searches for Locations based on their priority.

This Criterion is available only for Location Search.

## Arguments

- `operator`- Operator constant (GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the priority

The `value` argument requires:

- a list of ints for `Operator::BETWEEN`
- a single int for other Operators

## Example

### PHP

``` php
$query->query = new Criterion\Location\Priority(Criterion\Operator::GTE, 50);
```
