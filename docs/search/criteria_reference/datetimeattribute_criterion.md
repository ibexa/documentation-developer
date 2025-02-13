---
description: DateTimeAttribute Criterion
---

# DateTimeAttribute criterion

The [`DateTimeAttribute Search Criterion`](TODO: PHP REF) searches for products by value of a specified attribute, based on the [date and time attribute](date_and_time.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `value` - searched value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php))

## Example

### PHP

The following example lists all products for which the `event_date` attribute has value equal to 2025-07-06.

``` php
[[= include_file('code_samples/back_office/search/src/Query/DateTimeAttributeQuery.php') =]]
```
