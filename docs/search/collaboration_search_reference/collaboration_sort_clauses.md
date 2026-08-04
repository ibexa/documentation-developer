---
month_change: false
description: Sort Clauses available for Collaboration search
---

# Collaboration Search Sort Clauses reference

Sort Clauses are found in the [`Ibexa\Contracts\Collaboration\Value\Query\SortClause`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-collaboration-invitation-query-sortclause.html) namespace.
Use them to work with objects related to [Collaborative editing API](collaborative_editing_api.md).

## Invitation Search Sort Clauses

Invitation Search Sort Clauses are implementing the [SortClauseInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClauseInterface.html) interface:

| Name | Description |
| --- | --- |
| [CreatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-CreatedAt.html) | Sort by invitation's creation date |
| [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-Id.html) | Sort by invitation's ID |
| [Status](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-Status.html)| Sort by invitation's status |
| [UpdatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Query-SortClause-UpdatedAt.html) | Sort by the date and time when invitation was updated |

## Session Search Sort Clauses

Session Search Sort Clauses are implementing the [SortClauseInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-SortClauseInterface.html) interface:

| Name | Description |
| --- | --- |
| [CreatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-SortClause-CreatedAt.html) | Sort by session's creation date |
| [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-SortClause-Id.html) | Sort by session's ID |
| [UpdatedAt](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Session-Query-SortClause-UpdatedAt.html) | Sort by the date and time when session was updated |

### Example

The following example shows how to use them to sort the searched sessions:

``` php hl_lines="17"
[[= include_code('code_samples/collaboration/src/Query/Search.php') =]]
```

The returned active sessions are sorted by creation date (descending).
