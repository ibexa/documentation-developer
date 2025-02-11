---
description: DateTimeAttributeRange Criterion
---

# DateTimeAttribute criterion

The [`DateTimeAttributeRange Search Criterion`](TODO: PHP REF)` Search Criterion searches for products by their [date and time attribute](date_and_time.md), allowing you to search for values fitting into a given range.

## Arguments

- `identifier` - attribute's identifier (string)
- `min` - lower range value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php), optional)
- `max` - upper range value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php), optional)

## Example

### PHP

``` php
[[= include_file('code_samples/back_office/search/src/Query/DateTimeAttributeRangeQuery.php') =]]
```
