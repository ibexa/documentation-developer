---
description: Shipment Id Sort Clause
edition: commerce
---

# Shipment Id Sort Clause

The `Id` Sort Clause sorts search results by shipment Id.

## Arguments

- (optional) `sortDirection` - `Id` constant, either `Id::SORT_ASC` or `Id::SORT_DESC`

## Example

``` php
$shipmentQuery = new ShipmentQuery(
    null,
    $criteria,
    [
        new Id(Id::SORT_ASC)
    ]
);
```
