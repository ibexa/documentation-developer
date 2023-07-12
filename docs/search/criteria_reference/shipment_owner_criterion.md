---
description: Owner Criterion
edition: commerce
---

# Owner Criterion

The `Owner` Criterion searches for shipments based on the user reference.

## Arguments

- `UserReference` object - \Ibexa\Contracts\Core\Repository\Values\User\UserReference(int $userId)

## Example

``` php
$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Owner(
        \Ibexa\Contracts\Core\Repository\Values\User\UserReference(14)
    )
);
```

`Owner` Criterion accepts also multiple values:

``` php
$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Owner(
        [
           \Ibexa\Contracts\Core\Repository\Values\User\UserReference(14),
           \Ibexa\Contracts\Core\Repository\Values\User\UserReference(123),
        ]
    )
);
```