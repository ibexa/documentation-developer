---
description: Shipment Status Sort Clause
edition: commerce
---

# Shipment Status Sort Clause

The `Status` Sort Clause sorts search results by shipment status.

## Arguments

- (optional) `sortDirection` - `Status` constant, either `Status::SORT_ASC` or `Status::SORT_DESC`

## Example

``` php
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Checkout\Shipment\Query\SortClause\Status(
            \Ibexa\Contracts\Checkout\Shipment\Query\SortClause\Status::SORT_ASC)
    ]
);
```
