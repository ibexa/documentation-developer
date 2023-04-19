---
description: Shipment Currency Criterion
edition: commerce
---

# Shipment Currency Criterion

The `Currency` Search Criterion searches for shipments based on the currency code.

## Arguments

- `currency` - string that represents a currency code

## Example

``` php
$query = new ShipmentQuery( 
    new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\Currency('USD')
);
```
