---
description: Discount LogicalAnd Search Criterion
edition: commerce
---

# Discount LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches discounts if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

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
