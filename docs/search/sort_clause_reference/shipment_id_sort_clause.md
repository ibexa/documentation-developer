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
use Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface;
use Ibexa\Contracts\Shipping\Shipment\Query\SortClause\Id;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new Id(
            Id::SORT_ASC
        ),
    ]
);
```
