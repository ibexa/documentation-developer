---
description: Shipment LogicalAnd Search Criterion
edition: commerce
---

# Shipment LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches shipments if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;
use Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface;

/** @var ShippingMethodInterface $shippingMethod */
$query = new ShipmentQuery(
    new LogicalAnd(
        new CreatedAt(new DateTime('2023-03-01')),
        new ShippingMethod($shippingMethod)
    )
);
```
