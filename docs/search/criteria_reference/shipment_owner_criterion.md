---
description: Shipment Owner Search Criterion
edition: commerce
---

# Owner Criterion

The `Owner` Criterion searches for shipments based on the user reference.

## Arguments

- `UserReference` object - new \Ibexa\Core\Repository\Values\User\UserReference(int $userId)

## Example

``` php
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Owner;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;
use Ibexa\Core\Repository\Values\User\UserReference;

$query = new ShipmentQuery(
    new Owner(
        new UserReference(14)
    )
);
```

`Owner` Criterion accepts also multiple values:

``` php
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Owner;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var UserService $userService */
$user1 = $userService->loadUser(12345);
$user2 = $userService->loadUserByLogin('user');

$query = new ShipmentQuery(
    new Owner(
        [
            $user1,
            $user2,
        ]
    )
);
```
