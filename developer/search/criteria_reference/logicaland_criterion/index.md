# LogicalAnd Criterion

LogicalAnd Search Criterion

The [`LogicalAnd` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/LogicalAnd.php) matches content if all provided Criteria match.

When querying for [products](../../../product_catalog/product_api/index.md), use [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\LogicalAnd`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/LogicalAnd.php) instead.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\LogicalAnd(
    [
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\SectionIdentifier(['sports', 'news']),
    ]
);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <AND>
            <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
            <SectionIdentifierCriterion>news</SectionIdentifierCriterion>
        </AND>
    </Filter>
</Query>
```

**JSON**

```json
{
    "Query": {
        "Filter": {
            "AND": {
                "ContentTypeIdentifierCriterion": "article",
                "SectionIdentifierCriterion": "news"
            }
        }
    }
}
```
