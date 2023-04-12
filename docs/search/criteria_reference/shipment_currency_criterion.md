---
description: Shipment Currency Criterion
edition: commerce
---

# Shipment Currency Criterion

The `CurrencyCriterion` Search Criterion searches for shipments based on the currency code.

## Arguments

- `currency` - string that represents a currency code

## Example

``` php
$query->query = new Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\CurrencyCriterion('USD');
```
