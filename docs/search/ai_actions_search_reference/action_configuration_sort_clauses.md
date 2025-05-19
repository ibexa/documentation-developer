---
month_change: false
edition: lts-update
---

# Action Configuration Search Sort Clauses reference

Sort Clauses are found in the `Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause` namespace, implementing the [SortClauseInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClauseInterface.html) interface:

- [Enabled](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Enabled.html)
- [Id](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Id.html)
- [Identifier](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-SortClause-Identifier.html)

The following example shows how to use them to sort the searched Action Configurations:
``` php
[[= include_file('code_samples/ai_actions/src/Query/Search.php') =]]
```

The search results are sorted by:

- status, with enabled on top
- identifier, in ascending order.
