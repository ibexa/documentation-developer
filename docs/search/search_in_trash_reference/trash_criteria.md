---
description: Search Criteria for finding content items in trash.
page_type: reference
month_change: false
---

# Trash Search Criteria reference

Search Criteria for trash are found in the [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-content-query-criterion.html) namespace, implementing the [CriterionInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-CriterionInterface.html) interface:

| Criterion | Description |
|---|---|
| [ContentName](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ContentName.html) | Find content items by their name |
| [ContentTypeId](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ContentTypeId.html) | Find content items by their Content Type ID |
| [DateMetadata](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-DateMetadata.html) | Find content items by metadata dates. Can use the additional exclusive target `DateMetadata::TRASHED` for trash-specific searches |
| [MatchAll](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-MatchAll.html) | Match all content items (no filtering) |
| [MatchNone](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-MatchNone.html) | Match no content items (filter out all) |
| [SectionId](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-SectionId.html) | Find content items by their Section ID |
| [UserMetadata](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-UserMetadata.html) | Find content items by user metadata (creator or modifier) |

## Logical operators

| Operator | Description |
|---|---|
| [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalAnd.html) | Composite criterion to group multiple criteria using the AND condition |
| [LogicalNot](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalNot.html) | Negate the result of the wrapped criterion |
| [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalOr.html) | Composite criterion to group multiple criteria using the OR condition |

You can use these criteria to build complex search queries for content items that are held in trash. The search is performed using the [`Ibexa\Contracts\Core\Repository\TrashService::findTrashItems`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TrashService.html#method_findTrashItems) method.

The following example shows how you can use the criteria to find trashed content items:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->filter = new Criterion\LogicalAnd([
    new Criterion\ContentTypeId([2]), // Articles
    new Criterion\DateMetadata(
        Criterion\DateMetadata::TRASHED,
        Criterion\Operator::GTE,
        strtotime('-30 days')
    )
]);

// Search for articles trashed in the last 30 days
$results = $trashService->findTrashItems($query);
```

The criteria limit the result set to content items matching all of the conditions listed below:

- content type must be Article (Content Type ID: 2)
- content must have been trashed within the last 30 days