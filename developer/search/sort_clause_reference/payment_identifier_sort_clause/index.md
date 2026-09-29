# Payment Identifier Sort Clause

Payment Identifier Sort Clause

Editions: Commerce

The `Identifier` Sort Clause sorts search results by payment identifier.

## Arguments

- (optional) `sortDirection` - `Identifier` constant, either `Identifier::SORT_ASC` or `Identifier::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;

$criteria = null;

$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\Payment\Query\SortClause\Identifier(
            \Ibexa\Contracts\Payment\Payment\Query\SortClause\Identifier::SORT_ASC
        ),
    ]
);
```
