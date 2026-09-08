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
