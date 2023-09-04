---
description: Price Currency Criterion
---

# Price Currency Criterion

The `Currency` Search Criterion searches for prices based on the given currency.

## Arguments

- `currency` - a `CurrencyInterface` object that represents the currency (`Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface`)

## Example

### PHP

``` php
$currency = $priceService->getPriceById(123);

$query = new PriceQuery( 
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency($currency)
);
```
