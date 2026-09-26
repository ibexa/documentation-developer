# Depth Criterion

Depth Search Criterion

The [`Location\Depth` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/Location/Depth.php) searches for locations based on their depth in the content tree.

This Criterion is available only for Location Search.

## Arguments

- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `value` - int(s) representing the location depth(s)

The `value` argument requires:

- a list of ints for `Operator::IN`
- exactly two ints for `Operator::BETWEEN`
- a single int for other Operators

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\Location\Depth(Criterion\Operator::LT, 3);
```
