---
description: DateTimeAttributeRange Criterion
---

# DateTimeAttributeRange criterion

The `DateTimeAttributeRange Search Criterion` searches for products by value of a specified attribute, which must be based on the [date and time attribute](date_and_time.md) type.

## Arguments

- `identifier` - attribute's identifier (string)
- `min` - lower range value (inclusive) of [DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php) type. Optional.
- `max` - upper range value (inclusive) of [DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php) type. Optional.
