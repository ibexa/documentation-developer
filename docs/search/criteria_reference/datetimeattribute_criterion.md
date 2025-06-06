---
description: DateTimeAttribute Criterion
edition: lts-update
---

# DateTimeAttribute criterion

The [`DateTimeAttribute Search Criterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogDateTimeAttribute-Search-Criterion-DateTimeAttribute.html) searches for products by value of a specified attribute, based on the [date and time attribute](date_and_time.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `value` - searched value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php))

## Operators

The following operators are supported:

- [FieldValueCriterion::COMPARISON_EQ](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constant_COMPARISON_EQ)
- [FieldValueCriterion::COMPARISON_NEQ](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constant_COMPARISON_NEQ)
- [FieldValueCriterion::COMPARISON_LT](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constant_COMPARISON_LT)
- [FieldValueCriterion::COMPARISON_LTE](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constant_COMPARISON_LTE)
- [FieldValueCriterion::COMPARISON_GT](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constant_COMPARISON_GT)
- [FieldValueCriterion::COMPARISON_GTE](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CoreSearch-Values-Query-Criterion-FieldValueCriterion.html#constant_COMPARISON_GTE)

## Example

### PHP

The following example lists all products for which the `event_date` attribute has value equal to 2025-07-06.

``` php
[[= include_file('code_samples/back_office/search/src/Query/DateTimeAttributeQuery.php') =]]
```
