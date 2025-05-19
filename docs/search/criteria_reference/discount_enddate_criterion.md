---
description: Discount EndDate Search Criterion
edition: commerce
---

# Discount EndDate Criterion

The `EndDateCriterion` Search Criterion searches for discounts based on the date and time when they expire.

## Arguments

- `value` - searched value provided as the [DateTimeImmutable](https://www.php.net/manual/en/class.datetimeimmutable.php) object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Discounts\Value\Query\Criterion\LogicalAnd(
    new \Ibexa\Contracts\Discounts\Value\Query\Criterion\StartDateCriterion(
        new DateTimeImmutable('2025-04-11 14:07:03'), Operator::GTE
    ),
    new \Ibexa\Contracts\Discounts\Value\Query\Criterion\EndDateCriterion(
        new DateTimeImmutable('2027-04-11 14:07:02'), Operator::LTE
    ),
);

$discountQuery = new DiscountQuery($criteria);
```
