---
description: Discount IsEnabled Search Criterion
edition: commerce
---

# Discount IsEnabled Criterion

The `IsEnabledCriterion` Search Criterion searches for discounts based on whether the discount is enabled or not.

## Arguments

- `value` - Boolean value stating whether the discount is enabled or not

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Discounts\Value\Query\Criterion\IsEnabledCriterion(true);

$discountQuery = new DiscountQuery($criteria);
```
