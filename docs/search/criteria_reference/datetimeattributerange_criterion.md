---
description: DateTimeAttributeRange Criterion
edition: lts-update
---

# DateTimeAttributeRange criterion

The [`DateTimeAttributeRange Search Criterion`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalogDateTimeAttribute-Search-Criterion-DateTimeAttributeRange.html) searches for products by value of a specified attribute, which must be based on the [date and time attribute](date_and_time.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `min` - lower range value (inclusive) of [DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php) type. Optional.
- `max` - upper range value (inclusive) of [DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php) type. Optional.

## Example

### PHP

The following example lists all products for which the `event_date` attribute has value greater than 2025-01-01.


``` php
[[= include_file('code_samples/back_office/search/src/Query/DateTimeAttributeRangeQuery.php') =]]
```
