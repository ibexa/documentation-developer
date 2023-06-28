---
description: Order CurrencyCode Criterion
edition: commerce
---

# Order CurrencyCode Criterion

The `CurrencyCodeCriterion` Search Criterion searches for orders based on the currency code.

## Arguments

- `currency_code` - string that represents a currency code

## Example

``` php
$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CurrencyCodeCriterion('USD')
);
```
