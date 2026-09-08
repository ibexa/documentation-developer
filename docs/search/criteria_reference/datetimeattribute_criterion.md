---
description: DateTimeAttribute Criterion
---

# DateTimeAttribute criterion

The `DateTimeAttribute Search Criterion` searches for products by value of a specified attribute, based on the [date and time attribute](date_and_time.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `value` - searched value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php))

## Operators

The following operators are supported:

- `FieldValueCriterion::COMPARISON_EQ`
- `FieldValueCriterion::COMPARISON_NEQ`
- `FieldValueCriterion::COMPARISON_LT`
- `FieldValueCriterion::COMPARISON_LTE`
- `FieldValueCriterion::COMPARISON_GT`
- `FieldValueCriterion::COMPARISON_GTE`