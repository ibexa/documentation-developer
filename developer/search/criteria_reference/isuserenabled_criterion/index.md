# IsUserEnabled Criterion

IsUserEnabled Search Criterion

The [`IsUserEnabled` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/IsUserEnabled.php) searches for user accounts that are enabled or disabled.

## Arguments

- (optional) `value` - bool representing whether to search for enabled (default `true`) or disabled user accounts

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\IsUserEnabled();
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <IsUserEnabledCriterion>true</IsUserEnabledCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "IsUserEnabledCriterion": "true"
    }
}
```
