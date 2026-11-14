# Shipment LogicalOr Criterion

Shipment LogicalOr Search Criterion

Editions: Commerce

The `LogicalOr` Search Criterion matches shipments if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

```php
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var \Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface $shippingMethod */
$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\LogicalOr(
        new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\CreatedAt(new DateTime('2023-03-01')),
        new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod($shippingMethod)
    )
);
```
