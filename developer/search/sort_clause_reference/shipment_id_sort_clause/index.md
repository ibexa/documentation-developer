# Shipment Id Sort Clause

Shipment Id Sort Clause

Editions: Commerce

The `Id` Sort Clause sorts search results by shipment Id.

## Arguments

- (optional) `sortDirection` - `Id` constant, either `Id::SORT_ASC` or `Id::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var \Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Shipping\Shipment\Query\SortClause\Id(
            \Ibexa\Contracts\Shipping\Shipment\Query\SortClause\Id::SORT_ASC
        ),
    ]
);
```
