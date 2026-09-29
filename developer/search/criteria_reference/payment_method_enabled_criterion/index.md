# Payment Method Enabled Criterion

Payment Method Enabled Search Criterion

Editions: Commerce

The `Enabled` Search Criterion searches for payment methods based on whether the payment method is enabled or not.

## Arguments

- `value` - whether the payment method is enabled

## Example

### PHP

```php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;

$query = new PaymentMethodQuery(
    new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Enabled(true)
);
```
