---
description: Shipment LogicalAnd Criterion
edition: commerce
---

# Shipment LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches shipments if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\LogicalAnd(
    [
        new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\CreatedAt(new DateTime('2023-03-01')),
        new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod($shippingMethod)
    ]
);
```
