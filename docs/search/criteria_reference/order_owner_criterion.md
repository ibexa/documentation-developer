---
description: Order OwnerCriterion Search Criterion
edition: commerce
---

# Owner Criterion

The `OwnerCriterion` Criterion searches for orders based on the user reference.

## Arguments

- `UserReference` object - new \Ibexa\Core\Repository\Values\User\UserReference(int $userId)

## Example

``` php
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\OwnerCriterion;

/** @var UserService $userService */
$user = $userService->loadUserByLogin('user');

$query = new OrderQuery(
    new OwnerCriterion(
        $user
    )
);
```

`OwnerCriterion` Criterion accepts also multiple values:

``` php
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\OwnerCriterion;

/** @var UserService $userService */
$user1 = $userService->loadUser(12345);
$user2 = $userService->loadUserByLogin('user');

$query = new OrderQuery(
    new OwnerCriterion(
        [
            $user1,
            $user2,
        ]
    )
);
```
