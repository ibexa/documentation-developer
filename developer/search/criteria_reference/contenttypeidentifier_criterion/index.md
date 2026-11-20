# ContentTypeIdentifier Criterion

ContentTypeIdentifier Search Criterion

The [`ContentTypeIdentifier` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/ContentTypeIdentifier.php) searches for content based on the identifier of its content type.

## Arguments

- `value` - string(s) representing the content type identifier(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\ContentTypeIdentifier(['article', 'blog_post']);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ContentTypeIdentifierCriterion": "article"
    }
}
```
