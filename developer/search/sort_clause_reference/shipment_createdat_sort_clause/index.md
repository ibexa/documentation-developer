# Shipment CreatedAt Sort Clause

Shipment CreatedAt Sort Clause

Editions: Commerce

The `CreatedAt` Sort Clause sorts search results by the date and time when the shipment was created.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var \Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Shipping\Shipment\Query\SortClause\CreatedAt(
            \Ibexa\Contracts\Shipping\Shipment\Query\SortClause\CreatedAt::SORT_ASC
        ),
    ]
);
```
