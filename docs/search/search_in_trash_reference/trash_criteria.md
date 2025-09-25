---
description: Search Criteria for finding content items in trash.
page_type: reference
month_change: false
---

# Trash Search Criteria reference

| Criterion | Description |
|---|---|
| [ContentName](../contentname_criterion.md) | Find content items by their name |
| [ContentTypeId](../contenttypeid_criterion.md) | Find content items by their Content Type ID |
| [DateMetadata](../datemetadata_criterion.md) | Find content items by metadata dates. Can use the additional exclusive target `DateMetadata::TRASHED` for trash-specific searches |
| [MatchAll](../matchall_criterion.md) | Match all content items (no filtering) |
| [MatchNone](../matchnone_criterion.md) | Match no content items (filter out all) |
| [SectionId](../sectionid_criterion.md) | Find content items by their Section ID |
| [UserMetadata](../usermetadata_criterion.md) | Find content items by user metadata (creator or modifier) |

## Logical operators

| Operator | Description |
|---|---|
| [LogicalAnd](../logicaland_criterion.md) | Composite criterion to group multiple criteria using the AND condition |
| [LogicalNot](../logicalor_criterion.md) | Negate the result of the wrapped criterion |
| [LogicalOr](../logicalor_criterion.md) | Composite criterion to group multiple criteria using the OR condition |

You can use these criteria to build complex search queries for content items that are held in trash.

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