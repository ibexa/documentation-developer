# UserId Criterion

UserId Search Criterion

The [`UserId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/UserId.php) searches for content based on the User ID.

## Arguments

- `value` - int(s) representing the User ID(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\UserId([14]);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <UserIdCriterion>14</UserIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "UserIdCriterion": "14"
    }
}
```
