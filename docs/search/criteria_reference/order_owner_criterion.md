---
description: Order OwnerCriterion Criterion
edition: commerce
---

# Owner Criterion

The `OwnerCriterion` Criterion searches for orders based on the user reference.

## Arguments

- `UserReference` object - \Ibexa\Contracts\Core\Repository\Values\User\UserReference(int $userId)

## Example

``` php
$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\OwnerCriterion(
        \Ibexa\Contracts\Core\Repository\Values\User\UserReference(14)
    )
);
```

`OwnerCriterion` Criterion accepts also multiple values:

``` php
$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\OwnerCriterion(
        [
           \Ibexa\Contracts\Core\Repository\Values\User\UserReference(14),
           \Ibexa\Contracts\Core\Repository\Values\User\UserReference(123),
        ]
    )
);
```