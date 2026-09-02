# Shipment Identifier Sort Clause

Shipment Identifier Sort Clause

Editions: Commerce

The `Identifier` Sort Clause sorts search results by shipment identifier.

## Arguments

- (optional) `sortDirection` - `Identifier` constant, either `Identifier::SORT_ASC` or `Identifier::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

/** @var \Ibexa\Contracts\Shipping\Shipment\Query\CriterionInterface $criteria */
$shipmentQuery = new ShipmentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Shipping\Shipment\Query\SortClause\Identifier(
            \Ibexa\Contracts\Shipping\Shipment\Query\SortClause\Identifier::SORT_ASC
        ),
    ]
);
```
