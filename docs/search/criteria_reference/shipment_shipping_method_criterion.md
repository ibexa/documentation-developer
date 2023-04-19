---
description: Shipment ShippingMethod Criterion
edition: commerce
---

# Shipment ShippingMethod Criterion

The `ShippingMethodCriterion` Search Criterion searches for shipments based on a shipping method applied to them.

## Arguments

- `value` - one or an array of `ShippingMethodInterface` objects that indicate the shipping methods

## Example

``` php
$query->query = new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\ShippingMethod($shippingMethod);
```
