# Payment Id Sort Clause

Payment Id Sort Clause

Editions: Commerce

The `Id` Sort Clause sorts search results by payment ID.

## Arguments

- (optional) `sortDirection` - `Id` constant, either `Id::SORT_ASC` or `Id::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;

$criteria = null;

$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\Payment\Query\SortClause\Id(
            \Ibexa\Contracts\Payment\Payment\Query\SortClause\Id::SORT_ASC
        ),
    ]
);
```
