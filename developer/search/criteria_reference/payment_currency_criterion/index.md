# Payment Currency Criterion

Payment Currency Search Criterion

Editions: Commerce

The `Currency` Search Criterion searches for payments based on the currency code.

## Arguments

- `currency` - string that represents a currency code

## Example

### PHP

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;

$query = new PaymentQuery(
    new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency('EUR')
);
```
