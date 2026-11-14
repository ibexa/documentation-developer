# Validity Criterion

Validity Criterion

The [Validity URL Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/URL/Query/Criterion/Validity.php) matches URLs based on a validity flag.

## Arguments

- `isValid` - bool representing whether the matcher selects only valid URLs

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;

$query = new URLQuery();
$query->filter = new Criterion\Validity(true);
```
