---
description: Shipment Identifier Criterion
edition: commerce
---

# Shipment Identifier Criterion

The `IdentifierCriterion` Search Criterion searches for shipments based on the shipment identifier.

## Arguments

- `identifier` - string that represents the shipment identifier

## Example

``` php
$query->query = new Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\IdentifierCriterion('f1t7z-3rb3rt');
```
