# Order Updated Sort Clause

Order Updated Sort Clause

Editions: Commerce

The `Updated` Sort Clause sorts search results by the date and time when order status was updated.

## Arguments

- (optional) `sortDirection` - `Updated` constant, either `Updated::SORT_ASC` or `Updated::SORT_DESC`

## Example

```php
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$criteria = null;

$orderQuery = new OrderQuery(
    $criteria,
    [
        new \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Updated(
            \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Updated::SORT_ASC
        ),
    ]
);
```
