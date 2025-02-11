---
description: DateTimeAttributeRange Criterion
---

# DateTimeAttribute criterion

The [`DateTimeAttributeRange Search Criterion`](TODO: PHP REF)` searches for products by value of a specified attribute, which must be based on the [date and time attribute](date_and_time.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `min` - lower range value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php), optional)
- `max` - upper range value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php), optional)

## Example

### PHP

The following example lists all products for which the `event_date` attribute has value greater than 2025-01-01.


``` php
[[= include_file('code_samples/back_office/search/src/Query/DateTimeAttributeRangeQuery.php') =]]
```
