---
description: Shipment LogicalAnd Criterion
edition: commerce
---

# Shipment LogicalAnd Criterion

The `LogicalAndCriterion` Search Criterion matches shipments if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\LogicalAnd([
    new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\CreatedAt(new DateTime('2023-03-01')),
    new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\ShippingMethod($shippingMethod)
    ]
);
```
