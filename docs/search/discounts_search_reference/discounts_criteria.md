---
month_change: true
editions:
    - commerce
---

# Discounts Search Criterion reference

Search Criteria are found in the `Ibexa\Contracts\Discounts\Value\Query\Criterion` namespace, implementing the [CriterionInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-CriterionInterface.html) interface:

| Criterion | Description |
|---|---|
| [CreatedAtCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-CreatedAtCriterion.html) | Find discounts with given creation date|
| [CreatorCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-CreatorCriterion.html) | Find discounts created by specific users|
| [EndDateCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-EndDateCriterion.html) | Find discounts by their end date. For permanent discounts, the end date is set to `null` |
| [IdentifierCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-IdentifierCriterion.html) | Find discounts by their identifier |
| [IsEnabledCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-IsEnabledCriterion.html) | Find discounts by their status|
| [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-LogicalAnd.html) | Composite criterion to group multiple criterions using the AND condition |
| [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-LogicalOr.html) | Composite criterion to group multiple criterions using the OR condition |
| [NameCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-NameCriterion.html) | Find discounts by their name |
| [PriorityCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-PriorityCriterion.html) | Find discounts by their priority |
| [StartDateCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-StartDateCriterion.html) | Find discounts with given start date|
| [TypeCriterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-Criterion-TypeCriterion.html) | Find cart or catalog discounts by using constants from the [DiscountType](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-DiscountType.html) class|

You can use the [FieldValueCriterion's constants](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constants) like `FieldValueCriterion::COMPARISON_CONTAINS` or `FieldValueCriterion::COMPARISON_STARTS_WITH` to specify the operator for the condition.

Use the `limit` and `offset` properties of [DiscountQuery](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Query-DiscountQuery.html#constants) to limit the number of results and implement pagination.

The following example shows how you can use the criteria to find all the currently active discounts:

```php hl_lines="13-20"
[[= include_file('code_samples/discounts/src/Query/Search.php') =]]
```

The criteria limit the result set to discounts matching all of the conditions listed below:

- discount must be enabled
- discount start date is not after the current date
- discount end date is not before the current date or is not specified
