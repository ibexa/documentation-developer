# Payment Status Sort Clause

Payment Status Sort Clause

Editions: Commerce

The `Status` Sort Clause sorts search results by payment status.

## Arguments

- (optional) `sortDirection` - `Status` constant, either `Status::SORT_ASC` or `Status::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;

$criteria = null;

$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\Payment\Query\SortClause\Status(
            \Ibexa\Contracts\Payment\Payment\Query\SortClause\Status::SORT_ASC
        ),
    ]
);
```
