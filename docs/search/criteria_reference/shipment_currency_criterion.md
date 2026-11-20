---
description: Shipment Currency Search Criterion
edition: commerce
---

# Shipment Currency Criterion

The `Currency` Search Criterion searches for shipments based on the currency code.

## Arguments

- `currency` - an array of string currency codes

## Example

### PHP

``` php
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Currency;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

$query = new ShipmentQuery(
    new Currency(['USD', 'CZK'])
);
```
