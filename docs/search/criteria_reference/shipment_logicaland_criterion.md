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
$query->query = new Criterion\LogicalAndCriterion([
        new Criterion\CreatedAtCriterion(['2022-07-11T00:00:00+02:00', LT]),
        new Criterion\ShippingMethodCriterion(1);
    ]
);
```
