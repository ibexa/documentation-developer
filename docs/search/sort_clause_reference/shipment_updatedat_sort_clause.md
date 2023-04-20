---
description: Shipment UpdatedAt Sort Clause
edition: commerce
---

# Shipment UpdatedAt Sort Clause

The `UpdatedAt` Sort Clause sorts search results by the date and time when shipment status was updated.

## Arguments

- (optional) `sortDirection` - `UpdatedAt` constant, either `UpdatedAt::SORT_ASC` or `UpdatedAt::SORT_DESC`

## Example

``` php
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Checkout\Shipment\Query\SortClause\UpdatedAt(
            \Ibexa\Contracts\Checkout\Shipment\Query\SortClause\UpdatedAt::SORT_ASC)
    ]
);
```
