# SectionIdentifier Criterion

SectionIdentifier Search Criterion

The [`SectionIdentifier` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/SectionIdentifier.php) searches for content based on the identifier of the Section it's assigned to.

## Arguments

- `value` - string(s) representing the identifiers of the Section(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\SectionIdentifier(['sports', 'news']);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <SectionIdentifierCriterion>sports</SectionIdentifierCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "SectionIdentifierCriterion": "sports"
    }
}
```
