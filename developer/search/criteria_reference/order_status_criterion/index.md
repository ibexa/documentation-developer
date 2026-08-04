# Order Status Criterion

Order Status Search Criterion

Editions: Commerce

The `StatusCriterion` Search Criterion searches for orders based on order status.

## Arguments

- `status` - string that represents the status of the order, takes values defined in order management workflow

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\StatusCriterion('pending')
);
```
