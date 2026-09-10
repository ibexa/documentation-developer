# Payment Method CreatedAt Criterion

Payment Method CreatedAt Search Criterion

Editions: Commerce

The `CreatedAt` Search Criterion searches for payment methods based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

```php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$criteria = new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt(
    new DateTime('2023-03-01')
);
$query = new PaymentMethodQuery($criteria);
```
