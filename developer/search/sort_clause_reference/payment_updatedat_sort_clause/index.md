# Payment UpdatedAt Sort Clause

Payment UpdatedAt Sort Clause

Editions: Commerce

The `UpdatedAt` Sort Clause sorts search results by the date and time when payment status was updated.

## Arguments

- (optional) `sortDirection` - `UpdatedAt` constant, either `UpdatedAt::SORT_ASC` or `UpdatedAt::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;

$criteria = null;

$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\Payment\Query\SortClause\UpdatedAt(
            \Ibexa\Contracts\Payment\Payment\Query\SortClause\UpdatedAt::SORT_ASC
        ),
    ]
);
```
