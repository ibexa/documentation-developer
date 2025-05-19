---
month_change: false
edition: lts-update
---

# Action Configuration Search Criterion reference

Search criterions are found in the `Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion` namespace, implementing the [CriterionInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-CriterionInterface.html) interface:

| Criterion | Description |
|---|---|
| [Name](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Name.html) | Find Action Configurations matching given name. Use [FieldValueCriterion's constants](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constants) like `FieldValueCriterion::COMPARISON_CONTAINS` or `FieldValueCriterion::COMPARISON_STARTS_WITH` to specify the matching condition|
| [Enabled](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Enabled.html) | Find enabled or disabled Action Configurations |
| [Identifier](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Identifier.html) | Find Action Configuration having the exact given identifier |
| [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalAnd.html) | Composite criterion to group multiple criterions using the AND condition |
| [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-LogicalOr.html) | Composite criterion to group multiple criterions using the OR condition |
| [Type](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ConnectorAi-ActionConfiguration-Query-Criterion-Type.html) | Find Action Configuration having the exact given type |

The following example shows how to use them to find specific Action Configurations:
``` php
[[= include_file('code_samples/ai_actions/src/Query/Search.php') =]]
```

The result set contains Action Configurations that are:

- enabled, and
- with an identifier equal to `casual` or with a name starting with `Casual`.
