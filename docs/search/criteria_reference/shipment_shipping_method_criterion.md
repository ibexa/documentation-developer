---
description: Shipment ShippingMethod Criterion
edition: commerce
---

# Shipment ShippingMethod Criterion

The `ShippingMethodCriterion` Search Criterion searches for shipments based on a shipping method applied to them.

## Arguments

- `method_id` - integer that represents an ID of the shipping method that you want to match

## Example

``` php
$query->query = new Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\ShippingMethodCriterion(2);
```
