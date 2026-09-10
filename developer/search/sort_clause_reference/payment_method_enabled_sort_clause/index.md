# Payment Method Enabled Sort Clause

Payment Method Enabled Sort Clause

Editions: Commerce

The `Enabled` Sort Clause sorts search results by payment method status.

## Arguments

- (optional) `sortDirection` - `Enabled` constant, either `Enabled::SORT_ASC` or `Enabled::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;

$criteria = null;

$paymentMethodQuery = new PaymentMethodQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\Enabled(
            \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\Enabled::SORT_DESC
        ),
    ]
);
```
