---
description: Discount NameCriterion Search Criterion
edition: commerce
---

# Discount Name Criterion

The `NameCriterion` Search Criterion searches for discounts based on the discount name.

## Arguments

- `value` - string that represents the discount name

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Discounts\Value\Query\Criterion\NameCriterion('Summer sale');

$discountQuery = new DiscountQuery($criteria);
```
