# ContentId Criterion

ContentId Search Criterion

The [`ContentId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/ContentId.php) searches for content by its ID.

## Arguments

- `value` - int(s) representing the Content ID(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ContentId([62, 64]);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ContentIdCriterion>1,52</ContentIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ContentIdCriterion": "1,52"
    }
}
```
