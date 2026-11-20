# Order Price Criterion

Order Price Search Criterion

Editions: Commerce

The `PriceCriterion` searches for orders by their total net value.

## Arguments

- `value` - value to be matched, represents total net order value
- (optional) `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$criteria = new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\PriceCriterion(
    12900,
    'GTE'
);

$orderQuery = new OrderQuery($criteria);
```
