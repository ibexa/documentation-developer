# Shipment ShippingMethod Criterion

Shipment ShippingMethod Search Criterion

Editions: Commerce

The `ShippingMethod` Search Criterion searches for shipments based on a shipping method applied to them.

## Arguments

- `value` - one or an array of `ShippingMethodInterface` objects that indicate the shipping methods

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var \Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface $shippingMethod */
$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod($shippingMethod)
);
```
