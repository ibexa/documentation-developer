# Payment Method CreatedAt Sort Clause

Payment Method CreatedAt Sort Clause

Editions: Commerce

The `CreatedAt` Sort Clause sorts search results by the date and time when the payment method was created.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;

$criteria = null;

$paymentMethodQuery = new PaymentMethodQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\CreatedAt(
            \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\CreatedAt::SORT_ASC
        ),
    ]
);
```
