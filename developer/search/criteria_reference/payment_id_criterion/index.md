# Payment Id Criterion

Payment Id Search Criterion

Editions: Commerce

The `Id` Search Criterion searches for payments based on the payment ID.

## Arguments

- `id` - integer that represents the payment ID

## Example

### PHP

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;

$query = new PaymentQuery(
    new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Id(2)
);
```
