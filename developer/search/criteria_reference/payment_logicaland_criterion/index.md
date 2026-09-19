# Payment LogicalAnd Criterion

Payment LogicalAnd Search Criterion

Editions: Commerce

The `LogicalAnd` Search Criterion matches payments if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

```php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\LogicalAnd;

$query = new PaymentQuery();
$query->setQuery(new LogicalAnd(
    new CreatedAt(new DateTime('2023-03-01')),
    new Currency('USD'),
));
```
