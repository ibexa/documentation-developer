# LogicalAnd Criterion

LogicalAnd Criterion

The [`LogicalAnd` URL Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/URL/Query/Criterion/LogicalAnd.php) matches a URL if all provided Criteria match.

## Arguments

- `criterion` - the set of Criteria combined by the logical operator

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;

$query = new URLQuery();
$query->filter = new Criterion\LogicalAnd(
    [
        new Criterion\Validity(true),
        new Criterion\Pattern('ibexa.co'),
    ]
);
```
