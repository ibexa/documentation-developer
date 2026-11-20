# Visibility Criterion

Visibility Search Criterion

The [`Visibility` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/Visibility.php) searches for content based on whether it's visible or not.

This Criterion takes into account both hiding content and hiding locations.

When used with Content Search, the Criterion takes into account all assigned locations. This means that hidden content is returned if it has at least one visible location. Use Location Search to avoid this.

## Arguments

- `value` - Visibility constant (VISIBLE, HIDDEN)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\Visibility(Criterion\Visibility::HIDDEN);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <VisibilityCriterion>HIDDEN</VisibilityCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "VisibilityCriterion": "HIDDEN"
    }
}
```
