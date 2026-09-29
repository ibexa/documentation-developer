# Owner Criterion

Shipment Owner Search Criterion

Editions: Commerce

The `Owner` Criterion searches for shipments based on the user reference.

## Arguments

- `UserReference` object - new \\Ibexa\\Core\\Repository\\Values\\User\\UserReference(int $userId)

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Owner(
        new \Ibexa\Core\Repository\Values\User\UserReference(14)
    )
);
```

`Owner` Criterion accepts also multiple values:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var \Ibexa\Contracts\Core\Repository\UserService $userService */
$user1 = $userService->loadUser(12345);
$user2 = $userService->loadUserByLogin('user');

$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Owner(
        [
           $user1,
           $user2,
        ]
    )
);
```
