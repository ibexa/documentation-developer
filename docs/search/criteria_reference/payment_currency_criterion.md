---
description: Payment Currency Criterion
edition: commerce
---

# Payment Currency Criterion

The `Currency` Search Criterion searches for payments based on the currency code.

## Arguments

- `currency` - string that represents a currency code

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency('EUR');
```
