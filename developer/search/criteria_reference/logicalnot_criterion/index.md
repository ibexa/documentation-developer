# LogicalNot Criterion

LogicalNot Search Criterion

The [`LogicalNot` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/LogicalNot.php) matches content URL if the provided Criterion doesn't match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$contentTypeIdentifier = 'article';

$query = new Query();
$query->filter = new Criterion\LogicalNot(
    new Criterion\ContentTypeIdentifier($contentTypeIdentifier)
);
```

### REST API

**XML**

```xml
<Query>
    <Criterion>
        <LogicalNotCriterion>
            <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
        </LogicalNotCriterion>
    </Criterion>
</Query>
```

**JSON**

```json
{
  "Query": {
    "Criterion": {
      "LogicalNotCriterion": {
        "ContentTypeIdentifierCriterion": "article"
      }
    }
  }
}
```
