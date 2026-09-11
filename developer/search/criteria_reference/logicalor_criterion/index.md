# LogicalOr Criterion

LogicalOr Search Criterion

The [`LogicalOr` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/LogicalOr.php) matches content if at least one of the provided Criteria matches.

When querying for [products](../../../product_catalog/product_api/index.md), use [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\LogicalOr`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/LogicalOr.php) instead.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->filter = new Criterion\LogicalOr(
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
        <OR>
            <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
            <SectionIdentifierCriterion>news</SectionIdentifierCriterion>
        </OR>
    </Filter>
</Query>
```

**JSON**

```json
{
    "Query": {
        "Filter": {
            "OR": {
                "ContentTypeIdentifierCriterion": "article",
                "SectionIdentifierCriterion": "news"
            }
        }
    }
}
```
