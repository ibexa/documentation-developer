---
description: Content Type Search Criteria help define and fine-tune search queries for content types.
page_type: reference
month_change: false
---

# Content Type Search Criteria reference

| Criterion | Description |
|-------|-------------|
| ContainsFieldDefinitionId | Matches content types that contain a field definition with the specified ID. |
| ContentTypeGroupId | Matches content types by their assigned group ID. |
| ContentTypeGroupName | Matches content types by the name of their assigned group. |
| ContentTypeId | Matches content types by their ID. |
| ContentTypeIdentifier | Matches content types by their identifier. |
| IsSystem | Matches content types based on whether the group they belong to is system or not. |
| LogicalAnd | Implements a logical AND Criterion. It matches if ALL of the provided Criteria match. |
| LogicalOr | Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches. |
| LogicalNot | Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match. |

The following example shows how to use them to search for content types:

``` php hl_lines="29-31"
[[= include_code('code_samples/api/public_php_api/src/Command/FindContentTypeCommand.php') =]]
```
