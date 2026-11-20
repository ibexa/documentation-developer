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
use Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface;
use Ibexa\Contracts\Shipping\Shipment\Query\SortClause\UpdatedAt;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new UpdatedAt(
            UpdatedAt::SORT_ASC
        ),
    ]
);
```
