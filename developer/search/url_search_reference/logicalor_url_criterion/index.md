# LogicalOr Criterion

LogicalOr Criterion

The [`LogicalOr` URL Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/URL/Query/Criterion/LogicalOr.php) matches a URL if at least one of the provided Criteria match.

## Arguments

- `criterion` - the set of Criteria combined by the logical operator

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;

$query = new URLQuery();
$query->filter = new Criterion\LogicalOr(
    [
        new Criterion\SectionIdentifier(['sports', 'news']),
        new Criterion\Pattern('ibexa.co'),
    ]
);
```
