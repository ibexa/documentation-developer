---
description: Shipment ShippingMethod Criterion
edition: commerce
---

# Shipment ShippingMethod Criterion

The `ShippingMethod` Search Criterion searches for shipments based on a shipping method applied to them.

## Arguments

- `value` - one or an array of `ShippingMethodInterface` objects that indicate the shipping methods

## Example

``` php
$query = new ShipmentQuery( 
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\ShippingMethod($shippingMethod)
);
```
