---
description: DateTimeAttribute Criterion
---

# DateTimeAttribute criterion

The [`DateTimeAttribute Search Criterion`](TODO: PHP REF)  searches for products by their [date and time attribute](date_and_time.md) value.

## Arguments

- `identifier` - attribute's identifier (string)
- `value` - searched value ([DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php))

## Example

### PHP

``` php
[[= include_file('code_samples/back_office/search/src/Query/DateTimeAttributeQuery.php') =]]
```
