---
description: Discount TypeCriterion Search Criterion
edition: commerce
---

# Discount Type Criterion

The `TypeCriterion` Search Criterion searches for discounts based on the discount type.

## Arguments

- `value` - string that represents the discount type

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Discounts\Value\Query\Criterion\TypeCriterion('catalog');

$discountQuery = new DiscountQuery($criteria);
```
