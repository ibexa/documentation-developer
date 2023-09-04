---
description: Price Currency Criterion
---

# Price Currency Criterion

The `Currency` Search Criterion searches for prices based on the currency code.

## Arguments

- `currency_id` - a string currency code

## Example

### PHP

``` php
$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency('USD')
);
```
