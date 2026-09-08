# IsMainLocation Criterion

IsMainLocation Search Criterion

The [`IsMainLocation` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/LanguageCode.php) searches for locations based on whether they're the main location of a content item or not.

This Criterion is available only for Location Search.

## Arguments

- `value` - `IsMainLocation::MAIN` (0) or `IsMainLocation::NOT_MAIN` (1), representing whether to search for a main or not main location

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Location\IsMainLocation;

$query = new Query();
$query->query = new Criterion\Location\IsMainLocation(IsMainLocation::MAIN);
```
