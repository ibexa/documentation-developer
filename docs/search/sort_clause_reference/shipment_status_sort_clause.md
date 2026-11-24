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
use Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface;
use Ibexa\Contracts\Shipping\Shipment\Query\SortClause\Status;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new Status(
            Status::SORT_ASC
        ),
    ]
);
```
