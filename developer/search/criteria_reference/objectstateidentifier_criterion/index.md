# ObjectStateIdentifier Criterion

ObjectStateIdentifier Search Criterion

The [`ObjectStateIdentifier` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/ObjectStateId.php) searches for content based on its object state identifier.

## Arguments

- `value` - string(s) representing the object state identifier(s)
- `target` (optional for PHP) - string representing the object state group

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ObjectStateIdentifier(['ready']);
```

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ObjectStateIdentifier(['not_locked'], 'ibexa_lock');
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ObjectStateIdentifierCriterion>
            <value>not_locked</value>
            <target>ibexa_lock</target>
        </ObjectStateIdentifierCriterion>
    </Filter>
</Query>
```

**JSON**

```json
{
  "Query": {
    "Filter": {
      "ObjectStateIdentifierCriterion": {
        "value": "not_locked",
        "target": "ibexa_lock"
      }
    }
  }
}
```
