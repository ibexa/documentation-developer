---
description: Payment Currency Search Criterion
edition: commerce
---

# Payment Currency Criterion

The `Currency` Search Criterion searches for payments based on the currency code.

## Arguments

- `currency` - string that represents a currency code

## Example

### PHP

``` php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency;

$query = new PaymentQuery(
    new Currency('EUR')
);
```
