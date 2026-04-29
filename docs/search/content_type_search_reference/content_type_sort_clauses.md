---
description: Content Type Search Sort Clauses
month_change: false
---

# Content Type Search Sort Clauses

Content Type Search Sort Clauses are the sorting options for content types.
They're only supported by [Content Type Search (`ContentTypeService::findContentTypes`)](managing_content.md#finding-and-filtering-content-types).

Sort Clauses are found in the [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-contenttype-query-sortclause.html) namespace:

| Name | Description |
| --- | --- |
| [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-SortClause-Id.html)| Sort by content type's id |
| [Identifier](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-SortClause-Identifier.html)| Sort by content type's identifier |
| [Name](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-SortClause-Name.html)| Sort by content type's name |


The following example shows how to use them to sort the searched content types:

```php hl_lines="36-38"
[[= include_file('code_samples/api/public_php_api/src/Command/FindContentTypeCommand.php') =]]
```

You can change the default sorting order by using the `SORT_ASC` and `SORT_DESC` constants from [`AbstractSortClause`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-AbstractSortClause.html#constants).
