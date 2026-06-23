---
description: Payment Method LogicalAnd Search Criterion
edition: commerce
---

# Payment Method LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches payment methods if all provided Criteria match.

## Arguments

- `criteria` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Enabled;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\LogicalAnd;

$query = new PaymentMethodQuery();
$query->setQuery(new LogicalAnd(
    new CreatedAt(new DateTime('2023-03-01')),
    new Enabled(true),
));
```
