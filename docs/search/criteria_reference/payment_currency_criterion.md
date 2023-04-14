---
description: Payment Currency Criterion
edition: commerce
---

# Payment Currency Criterion

The `CurrencyCriterion` Search Criterion searches for payments based on the currency code.

## Arguments

- `currency` - string that represents a currency code

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\CurrencyCriterion('EUR');
```