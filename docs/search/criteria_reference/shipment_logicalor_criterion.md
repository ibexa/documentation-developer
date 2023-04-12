---
description: Shipment LogicalOr Criterion
edition: commerce
---

# Shipment LogicalOr Criterion

The `LogicalOrCriterion` Search Criterion matches shipments if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new Criterion\LogicalOrCriterion([
        new Criterion\CreatedAtCriterion(['2022-07-11T00:00:00+02:00', GT]),
        new Criterion\ShippingMethodCriterion(2);
    ]
);
```
