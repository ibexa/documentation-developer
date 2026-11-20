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
use Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface;
use Ibexa\Contracts\Shipping\Shipment\Query\SortClause\Identifier;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new Identifier(
            Identifier::SORT_ASC
        ),
    ]
);
```
