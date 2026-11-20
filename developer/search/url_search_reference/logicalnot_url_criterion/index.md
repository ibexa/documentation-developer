# LogicalNot Criterion

LogicalNot Criterion

The [`LogicalNot` URL Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/URL/Query/Criterion/LogicalNot.php) matches a URL if the provided Criterion doesn't match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;

$query = new URLQuery();
$query->filter = new Criterion\LogicalNot(
    new Criterion\Pattern('ibexa.co')
);
```
