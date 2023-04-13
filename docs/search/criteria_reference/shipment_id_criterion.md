---
description: Shipment Id Criterion
edition: commerce
---

# Shipment Id Criterion

The `IdCriterion` Search Criterion searches for shipments based on the shipment ID.

## Arguments

- `id` - integer that represents the shipment ID

## Example

``` php
$query->query = new Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\IdCriterion(2);
```
