---
description: Discount LogicalOr Search Criterion
edition: commerce
---

# Discount LogicalOr Criterion

The `LogicalOr` Search Criterion matches discounts if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$criteria = new LogicalOr(
    new StartDateCriterion(new DateTimeImmutable('2025-04-11 14:07:03'), Operator::GTE),
    new CreatedAtCriterion(new DateTime('2025-04-11 14:07:02'), Operator::GTE),
);

$discountQuery = new DiscountQuery($criteria);
```
