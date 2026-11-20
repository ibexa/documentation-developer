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
use Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface;
use Ibexa\Contracts\Shipping\Shipment\Query\SortClause\CreatedAt;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new CreatedAt(
            CreatedAt::SORT_ASC
        ),
    ]
);
```
