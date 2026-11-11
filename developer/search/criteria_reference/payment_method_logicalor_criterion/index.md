# Payment Method LogicalOr Criterion

Payment Method LogicalOr Search Criterion

Editions: Commerce

The `LogicalOr` Search Criterion matches payment methods if at least one of the provided Criteria matches.

## Arguments

- `criteria` - a set of Criteria combined by the logical operator

## Example

### PHP

```php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\LogicalOr;

$query = new PaymentMethodQuery();
$query->setQuery(new LogicalOr(
    new CreatedAt(new DateTime('2023-03-01')),
    new CreatedAt(new DateTime('2023-05-01')),
));
```
