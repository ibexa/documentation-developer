# ContentTypeId Criterion

ContentTypeId Search Criterion

The [`ContentTypeId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/ContentTypeId.php) searches for content based on the ID of its content type.

## Arguments

- `value` - int(s) representing the content type ID(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ContentTypeId([44]);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ContentTypeIdCriterion>44</ContentTypeIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ContentTypeIdCriterion": 44
    }
}
```
