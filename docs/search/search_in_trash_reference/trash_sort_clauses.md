---
description: Sort Clauses for ordering search results of content items in trash.
page_type: reference
month_change: false
---

# Trash Search Sort Clauses reference

Sort Clauses for trash are found in the [`Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-content-query-sortclause.html) namespace, implementing the [SortClauseInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClauseInterface.html) interface:

| Name | Description |
| --- | --- |
| [ContentName](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-ContentName.html) | Sort by content item name |
| [ContentTypeName](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-ContentTypeName.html) | Sort by Content Type name |
| [DateTrashed](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-DateTrashed.html) | Sort by the date when content was moved to trash (exclusive to trash search) |
| [Depth](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Depth.html) | Sort by the original depth in the content tree |
| [Path](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Path.html) | Sort by the original path in the content tree |
| [Priority](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Priority.html) | Sort by content item priority |
| [SectionName](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-SectionName.html) | Sort by Section name |
| [UserLogin](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-UserLogin.html) | Sort by the login of the user who created the content |

The following example shows how to use sort clauses to order the searched trash items:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new Query();
$query->sortClauses = [
    new SortClause\DateTrashed(Query::SORT_DESC),
    new SortClause\ContentName(Query::SORT_ASC),
    new SortClause\ContentTypeName(Query::SORT_ASC)
];

// Search results will be sorted by:
// 1. Date trashed (most recent first)
// 2. Content name (alphabetically)
// 3. Content Type name (alphabetically)
$results = $trashService->findTrashItems($query);
```

The returned trash items are sorted by:

- date when content was trashed (descending - most recent first)
- content name (ascending - alphabetically)
- Content Type name (ascending - alphabetically)

You can change the default sorting order by using the `Query::SORT_ASC` and `Query::SORT_DESC` constants from [`Query`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query.html#constants).