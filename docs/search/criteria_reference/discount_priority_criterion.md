---
description: Discount PriorityCriterion Search Criterion
edition: commerce
---

# Priority Criterion

The `PriorityCriterion` Criterion searches for discounts based on their priority.

## Arguments

- `value` - numerical value representing the discount's priority

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Discounts\Value\Query\Criterion\PriorityCriterion(5);

$discountQuery = new DiscountQuery($criteria);
```
