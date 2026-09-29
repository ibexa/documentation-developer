# IsBookmarked Criterion

IsBookmarked Search Criterion

The [`IsBookmarked` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/Location/IsBookmarked.php) searches for location based on whether it's bookmarked or not. It works with current user reference.

This Criterion is available only for location Search.

## Arguments

- `value` - bool representing whether to search for bookmarked location (default `true`) or not bookmarked location (`false`)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Location\IsBookmarked;

$query = new LocationQuery();
$query->filter = new IsBookmarked();
/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */
$results = $searchService->findLocations($query);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <IsBookmarkedCriterion>true</IsBookmarkedCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "IsBookmarkedCriterion": true
    }
}
```
