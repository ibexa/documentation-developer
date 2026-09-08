# Pattern Criterion

Pattern Criterion

The [`Pattern` URL Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/URL/Query/Criterion/SectionId.php) matches URLs that contain the provided pattern.

## Arguments

- `pattern` - string representing the pattern that needs to be a part of the URL

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;

$query = new URLQuery();
$query->filter = new Criterion\Pattern('ibexa.co');
```
