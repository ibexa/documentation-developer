---
description: Discount CreatorCriterion Search Criterion
edition: commerce
---

# Creator Criterion

The `CreatorCriterion` Criterion searches for discounts based on the user reference.

## Arguments

- `UserReference` object - \Ibexa\Contracts\Core\Repository\Values\User\UserReference(int $userId)

## Example

### PHP

``` php
$query = new DiscountQuery(
    new \Ibexa\Contracts\Discounts\Value\Query\Criterion\CreatorCriterion(
        \Ibexa\Core\Repository\Values\User\UserReference(14)
    )
);
```
