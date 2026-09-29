# RemoteId / ContentRemoteId Criterion

RemoteId / ContentRemoteId Search Criterion

The [`RemoteId` / `ContentRemoteId` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/RemoteId.php) searches for content based on its remote content ID.

## Arguments

- `value` - string(s) representing the remote IDs

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\RemoteId('abab615dcf26699a4291657152da4337');
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ContentRemoteIdCriterion>abab615dcf26699a4291657152da4337</ContentRemoteIdCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ContentRemoteIdCriterion": "abab615dcf26699a4291657152da4337"
    }
}
```
