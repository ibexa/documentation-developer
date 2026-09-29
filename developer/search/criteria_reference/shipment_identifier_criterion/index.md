# Shipment Identifier Criterion

Shipment Identifier Search Criterion

Editions: Commerce

The `Identifier` Search Criterion searches for shipments based on the shipment identifier.

## Arguments

- `identifier` - string that represents the shipment identifier

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Identifier('f1t7z-3rb3rt')
);
```
