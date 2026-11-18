---
description: Shipment LogicalOr Search Criterion
edition: commerce
---

# Shipment LogicalOr Criterion

The `LogicalOr` Search Criterion matches shipments if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\LogicalOr;
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;
use Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface;

/** @var ShippingMethodInterface $shippingMethod */
$query = new ShipmentQuery(
    new LogicalOr(
        new CreatedAt(new DateTime('2023-03-01')),
        new ShippingMethod($shippingMethod)
    )
);
```
