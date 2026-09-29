# Payment Order Criterion

Payment Order Search Criterion

Editions: Commerce

The `Order` Search Criterion searches for payments based on an ID of an associated order.

## Arguments

- `order_id` - integer that represents an ID of an associated order

## Example

### PHP

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;

/** @var \Ibexa\Contracts\OrderManagement\OrderServiceInterface $orderService */
$order = $orderService->getOrder(4);

$query = new PaymentQuery(
    new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Order($order)
);
```
