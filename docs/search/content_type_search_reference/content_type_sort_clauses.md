---
description: Content Type Search Sort Clauses
month_change: true
---

# Content Type Search Sort Clauses

Content Type Search Sort Clauses are the sorting options for content types.
They're only supported by [Content Type Search (`ContentTypeService::findContentTypes`)](managing_content.md#finding-and-filtering-content-types).

Sort Clauses are found in the [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause`](api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-SortClause.html) namespace:

| Name | Description |
| --- | --- |
| [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-SortClause-Id.html)| Sort by content type's id |
| [Identifier](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-SortClause-Identifier.html)| Sort by content type's identifier |
| [Name](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-SortClause-Name.html)| Sort by content type's name |


The following example shows how to use them to sort the searched content items:

```php hl_lines="18-20"
<?php

declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\ContentTypeQuery;

// Example: find content types whose identifier is "folder" or "article" *and* are in group 1, or identifier is "user":
$query = new ContentTypeQuery(
    new Criterion\LogicalOr([
        new Criterion\LogicalAnd([
            new Criterion\ContentTypeIdentifier(['folder','article']),
            new Criterion\ContentTypeGroupIds([1]),
        ]),
        new Criterion\ContentTypeIdentifier(['user']),
    ]),
    [
        new SortClause\Id(),
        new SortClause\Identifier(),
        new SortClause\Name(),
    ]
);

$results = $contentTypeService->findContentTypes($query);
```

You can change the default sorting order by using the `SORT_ASC` and `SORT_DESC` constants from [`AbstractSortClause`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-AbstractSortClause.html#constants).
