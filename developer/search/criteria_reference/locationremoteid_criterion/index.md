# LocationRemoteId Criterion

LocationRemoteId Search Criterion

The [`LocationRemoteId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/LocationRemoteId.php) searches for content based in the location remote ID.

## Arguments

- `value` - string(s) representing the location remote ID(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\LocationRemoteId(['4d1e5f216c0a7aaab7f005ffd4b6a8a8', 'b81ef3e62b514188bfddd2a80d447d34']);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <LocationRemoteIdCriterion>3aaeefdb0ae573ac91f6d6ea78d230b7</LocationRemoteIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "LocationRemoteIdCriterion": "3aaeefdb0ae573ac91f6d6ea78d230b7"
    }
}
```
