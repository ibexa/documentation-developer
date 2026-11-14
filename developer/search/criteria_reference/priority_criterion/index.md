# Priority Criterion

Priority Search Criterion

The [`Location\Priority` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/Location/Priority.php) searches for locations based on their priority.

This Criterion is available only for Location Search.

## Arguments

- `operator`- Operator constant (GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the priority

The `value` argument requires:

- a list of ints for `Operator::BETWEEN`
- a single int for other Operators

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\Location\Priority(Criterion\Operator::GTE, 50);
```
