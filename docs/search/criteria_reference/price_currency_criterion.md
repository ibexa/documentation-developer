---
description: Price Currency Criterion
---

# Price Currency Criterion

The `Currency` Search Criterion searches for prices based on the given currency.

## Arguments

- `currency` - a single object or an array of `CurrencyInterface` objects that represent the currency (`Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface`)

## Example

### PHP

``` php
$currency = $priceService->getPriceById('EUR');

$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency($currency)
);
```
