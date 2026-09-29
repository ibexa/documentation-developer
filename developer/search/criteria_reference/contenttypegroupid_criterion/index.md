# ContentTypeGroupId Criterion

ContentTypeGroupId Search Criterion

The [`ContentTypeGroupId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/ContentTypeGroupId.php) searches for content based on the ID of its content type group.

## Arguments

- `value` - int(s) representing the content type group ID(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ContentTypeGroupId([1, 2]);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ContentTypeGroupIdCriterion>1</ContentTypeGroupIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ContentTypeGroupIdCriterion": [1, 2]
    }
}
```

## Use case

You can use the `ContentTypeGroupId` Criterion to query all Media content items (the default ID for the Media content type group is 3):

```php
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ContentTypeGroupId([3]);

/** @var SearchService $searchService */
$results = $searchService->findContent($query);
$media = [];
foreach ($results->searchHits as $searchHit) {
    $media[] = $searchHit;
}
```
