---
description: Shipment CreatedAt Sort Clause
edition: commerce
---

# Shipment CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time when the shipment was created.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

``` php
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Checkout\Shipment\Query\SortClause\CreatedAt(
            \Ibexa\Contracts\Checkout\Shipment\Query\SortClause\CreatedAt::SORT_ASC)
    ]
);
```
