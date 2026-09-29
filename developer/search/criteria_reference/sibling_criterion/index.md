# Sibling Criterion

Sibling Search Criterion

The [`Sibling` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/Sibling.php) searches for content under the same parent as the indicated location.

## Arguments

- `locationId` - int representing the location ID
- `parentLocationId` - int representing the parent location ID

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\Sibling(59, 2);
```

You can also use the named constructor `Criterion\Sibling::fromLocation` and provide it with the location object:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
/** @var \Ibexa\Contracts\Core\Repository\LocationService $locationService */
$location = $locationService->loadLocation(59);
$query->query = Criterion\Sibling::fromLocation($location);
```

### REST API

### REST API

**XML**

```xml
<Query>
    <Filter>
        <SiblingCriterion>
            <locationId>85</locationId>
            <parentLocationId>81</parentLocationId>
        </SiblingCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "SiblingCriterion": {
            "locationId": 85,
            "parentLocationId": 81
        }
    }
}
```
