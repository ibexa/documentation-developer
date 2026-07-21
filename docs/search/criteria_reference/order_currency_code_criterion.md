---
description: Order CurrencyCode Search Criterion
edition: commerce
---

# Order CurrencyCode Criterion

The `CurrencyCodeCriterion` Search Criterion searches for orders based on the currency code.

## Arguments

- `currency_code` - string that represents a currency code

## Example

### PHP

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CurrencyCodeCriterion('USD')
);
```
