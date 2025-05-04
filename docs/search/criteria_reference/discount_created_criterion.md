---
description: Discount CreatedAt Search Criterion
edition: commerce
---

# Discount CreatedAt Criterion

The `CreatedAtCriterion` Search Criterion searches for discounts based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatedAtCriterion(
    new DateTime('2025-04-11 14:07:02'), Operator::GTE
);

$discountQuery = new DiscountQuery($criteria);
```
