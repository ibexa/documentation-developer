---
description: Content Type Search Sort Clauses
month_change: false
---

# Content Type Search Sort Clauses

Content Type Search Sort Clauses are the sorting options for content types.
They're only supported by [Content Type Search (`ContentTypeService::findContentTypes`)](managing_content.md#finding-and-filtering-content-types).

Sort Clauses are found in the `Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause` namespace:

| Name | Description |
| --- | --- |
| Id| Sort by content type's id |
| Identifier| Sort by content type's identifier |
| Name| Sort by content type's name |
