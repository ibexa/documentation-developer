# Payment LogicalOr Criterion

Payment LogicalOr Search Criterion

Editions: Commerce

The `LogicalOr` Search Criterion matches payments if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\LogicalOr;

$query = new PaymentQuery();
$query->setQuery(new LogicalOr(
    new CreatedAt(new DateTime('2023-03-01')),
    new Currency('USD'),
));
```
