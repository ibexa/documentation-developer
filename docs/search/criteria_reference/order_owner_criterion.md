---
description: Owner Criterion
edition: commerce
---

# Owner Criterion

The `Owner` Criterion searches for orders based on the user reference.

## Arguments

- `user reference` - \Ibexa\Contracts\Core\Repository\Values\User\UserReference(int $userId)

## Example

``` php
$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\OwnerCriterion(
        \Ibexa\Contracts\Core\Repository\Values\User\UserReference(14)
    )
);
```

Owner Criterion accepts also owners board:

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