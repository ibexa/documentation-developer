# Shipment Status Criterion

Shipment Status Search Criterion

Editions: Commerce

The `Status` Search Criterion searches for shipments based on shipment status.

## Arguments

- `status` - string that represents the status of the shipment, takes values defined in shipment processing workflow

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Status('pending')
);
```
