# Shipment Currency Criterion

Shipment Currency Search Criterion

Editions: Commerce

The `Currency` Search Criterion searches for shipments based on the currency code.

## Arguments

- `currency` - an array of string currency codes

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Currency(['USD', 'CZK'])
);
```
