---
description: Content Type Search Criteria help define and fine-tune search queries for content types.
page_type: reference
month_change: false
---

# Content Type Search Criteria reference

Content Type Search Criteria are only supported by [Content Type Search (`ContentTypeService::findContentTypes`)](managing_content.md#finding-and-filtering-content-types).

| Criterion | Description |
|-------|-------------|
| [ContainsFieldDefinitionId](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-ContainsFieldDefinitionId.html) | Matches content types that contain a field definition with the specified ID. |
| [ContentTypeGroupId](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-ContentTypeGroupId.html) | Matches content types by their assigned group ID. |
| [ContentTypeGroupName](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-ContentTypeGroupName.html) | Matches content types by the name of their assigned group. |
| [ContentTypeId](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-ContentTypeId.html) | Matches content types by their ID. |
| [ContentTypeIdentifier](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-ContentTypeIdentifier.html) | Matches content types by their identifier. |
| [IsSystem](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-IsSystem.html) | Matches content types based on whether the group they belong to is system or not. |
| [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-LogicalAnd.html) | Implements a logical AND Criterion. It matches if ALL of the provided Criteria match. |
| [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-LogicalOr.html) | Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches. |
| [LogicalNot](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ContentType-Query-Criterion-LogicalNot.html) | Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match. |

The following example shows how to use them to search for content types:

```php hl_lines="29-31"
[[= include_file('code_samples/api/public_php_api/src/Command/FindContentTypeCommand.php') =]]
```
