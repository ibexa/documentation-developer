---
description: Shipment Identifier Sort Clause
edition: commerce
---

# Shipment Identifier Sort Clause

The `Identifier` Sort Clause sorts search results by shipment identifier.

## Arguments

- (optional) `sortDirection` - `Identifier` constant, either `Identifier::SORT_ASC` or `Identifier::SORT_DESC`

## Example

``` php
$shipmentQuery = new ShipmentQuery(
    null,
    $criteria,
    [
        new Identifier(Identifier::SORT_ASC)
    ]
);
```
