---
description: Shipment LogicalOr Criterion
edition: commerce
---

# Shipment LogicalOr Criterion

The `LogicalOr` Search Criterion matches shipments if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\LogicalOr([
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\CreatedAt(new DateTime('2023-03-01')),
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod($shippingMethod)
    ]
);
```
