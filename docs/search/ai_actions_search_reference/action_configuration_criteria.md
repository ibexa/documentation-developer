---
month_change: false
description: Search Criteria available for Action Configuration search
---

# Action Configuration Search Criterion reference

Search criteria are found in the `Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion` namespace, implementing the CriterionInterface interface:

| Criterion | Description |
|---|---|
| Name | Find Action Configurations matching given name. Use FieldValueCriterion's constants like `FieldValueCriterion::COMPARISON_CONTAINS` or `FieldValueCriterion::COMPARISON_STARTS_WITH` to specify the matching condition|
| Enabled | Find enabled or disabled Action Configurations |
| Identifier | Find Action Configuration having the exact given identifier |
| LogicalAnd | Composite criterion to group multiple criteria using the AND condition |
| LogicalOr | Composite criterion to group multiple criteria using the OR condition |
| Type | Find Action Configuration having the exact given type |

The following example shows how to use them to find specific Action Configurations:

``` php
[[= include_code('code_samples/ai_actions/src/Query/Search.php') =]]
```

The result set contains Action Configurations that are:

- enabled, and
- with an identifier equal to `casual` or with a name starting with `Casual`.
