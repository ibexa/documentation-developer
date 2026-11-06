# Shipment Id Criterion

Shipment Id Search Criterion

Editions: Commerce

The `Id` Search Criterion searches for shipments based on the shipment ID.

## Arguments

- `id` - integer that represents the shipment ID

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Id(2)
);
```
