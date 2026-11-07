# LocationId Criterion

LocationId Search Criterion

The [`LocationId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/LocationId.php) searches for content based in the location ID.

## Arguments

- `value` - int(s) representing the location ID(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\LocationId(62);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <LocationIdCriterion>62</LocationIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "LocationIdCriterion": "62"
    }
}
```
