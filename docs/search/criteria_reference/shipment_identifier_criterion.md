---
description: Shipment Identifier Criterion
edition: commerce
---

# Shipment Identifier Criterion

The `Identifier` Search Criterion searches for shipments based on the shipment identifier.

## Arguments

- `identifier` - string that represents the shipment identifier

## Example

``` php
$query = new ShipmentQuery( 
    new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\Identifier('f1t7z-3rb3rt')
);
```
