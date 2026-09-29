# ObjectStateId Criterion

ObjectStateId Search Criterion

The [`ObjectStateId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/ObjectStateId.php) searches for content based on its object state ID.

## Arguments

- `value` - int(s) representing the object state ID(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ObjectStateId([4, 5]);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ObjectStateIdCriterion>1</ObjectStateIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ObjectStateIdCriterion": "1"
    }
}
```
